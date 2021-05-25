<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Google;
use Carbon\Carbon;

use Illuminate\Session;
use PhpParser\Node\Stmt\TryCatch;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request as GizzleRequest;

// set_time_limit(0);

class GoogleController extends Controller
{
    private $client;
    private $drive;
    private const FILE_TYPE_SPREADSHEET = 'application/vnd.google-apps.spreadsheet';
    private const FILE_TYPE_DOCUMENT = 'application/vnd.google-apps.document';
    private const FILE_TYPE_PRESENTATION = 'application/vnd.google-apps.presentation';

    public function __construct(Google $google, Request $request)
    {
        $this->client = $google->client();
        $token = $request->session()->get('access_token');
        $this->client->setAccessToken(json_encode($token));
        $this->drive = $google->drive($this->client);
    }

    public  function  getFilesFromParentFolder($parent_id)
    {
        $optParams = [
            'q' => " '" . $parent_id . "'  in parents and trashed = false",
            'fields' => 'files(id, name, modifiedTime, iconLink, webViewLink, parents, properties, fileExtension, mimeType, size, webContentLink, exportLinks)',
            "includeItemsFromAllDrives" => true,
            "supportsAllDrives" => true
        ];
        $result_query = $this->drive->files->listFiles($optParams);

        $files = $result_query->getFiles();

        $files_array = [];

        foreach ($files as $key => $file) {
            $files_array[$key] = [
                'id' => $file['id'],
                'name' => $file['name'],
                'icon' => $file['iconLink'],
                'modifiedTime' => date('Y-m-d H:i:s', strtotime($file['modifiedTime'])),
                'parentIds' => $file['parents'],
                'type' => $file['mimeType'],
                'size' => $file['size'],
                'webviewLink' => $file['webViewLink'],
                'webContentLink' => $file['webContentLink']
            ];
        }

        return $files_array;
    }


    public function files(Request $request, $parent_id)
    {
        $response = [
            'success' => true,
            'data' => $this->getFilesFromParentFolder($parent_id)
        ];

        return response()->json($response, 200);
    }

    public function getSharedDrives()
    {
        $pageToken = NULL;
        $result = array();
        do {
            try {
                $parameters = array();
                if ($pageToken) {
                    $parameters['pageToken'] = $pageToken;
                }
                $drives = $this->drive->drives->listDrives($parameters);

                $result = array_merge($result, $drives->getDrives());
                $pageToken = $drives->getNextPageToken();
            } catch (Exception $e) {
                print "An error occurred: " . $e->getMessage();
                $pageToken = NULL;
            }
        } while ($pageToken);
        return response()->json($result, 200);
    }

    public function getAllFilesFromDrive()
    {
        $pageToken = NULL;
        $result = array();
        do {
            try {
                $parameters = array();
                $parameters['fields'] = 'files(id, name, modifiedTime, iconLink, webViewLink, parents, properties, fileExtension, mimeType, size, webContentLink, exportLinks)';
                $parameters['q'] = "trashed = false";
                if ($pageToken) {
                    $parameters['pageToken'] = $pageToken;
                }
                $files = $this->drive->files->listFiles($parameters);
                $result = array_merge($result, $files->getFiles());
                foreach ($result as $file) {
                    if ($file['parents'] == null) {
                        $file->setParents(array('0AMyvxxX7olLcUk9PVA'));
                    }
                }
                $pageToken = $files->getNextPageToken();
            } catch (Exception $e) {
                print "An error occurred: " . $e->getMessage();
                $pageToken = NULL;
            }
        } while ($pageToken);

        return $result;
    }

    public function  exportToGoogleDrive($folderName)
    {
        $files = $this->getAllFilesFromDrive();
        foreach ($files as $file) {
            $getExportFormat = $this->getExportMymeType($file);
            $exportFolderIsExists = $this->checkExistsExportFolder($file['parents'][0], $folderName);
            $export_folderId = $this->getExportFolderId($file['parents'][0], $folderName);

            if ($getExportFormat && !$exportFolderIsExists) {
                $this->createExportFolder($file['parents'], $folderName);
            }

            if (
                $getExportFormat && $exportFolderIsExists &&
                ($this->checkModifiedTimeOfOriginalFile($export_folderId, $file, $file['name']) == false || $this->checkExportFileInExportFolder($export_folderId, $file['name']) == false)
            ) {
                $this->convertGoogleDoc($file, $export_folderId);
            }

            // if ($getExportFormat && $exportFolderIsExists && $this->checkModifiedTimeOfOriginalFile($export_folderId, $file, $file['name']) == true) {
            //     $this->updateDocInExportFolder($export_folderId, $file['name']);
            // }
        }
    }
    /*public function makeTree(Array &$files, $parent_id = '') : array {
        $branch = [];
        foreach ($files as &$file) {
            if ($file['parents'] != null && $file['parents'][0] == $parent_id)  {
                $file['children'] = $this->makeTree($files, $file['id']);
                $branch[$file['name']] = $file;
                unset($file);
            }
        }
        return $branch;
    }*/
    public function getExportUrl($file)
    {
        $exportURL = '';
        switch ($file->getMimeType()) {
            case self::FILE_TYPE_SPREADSHEET:
                $exportURL = "https://docs.google.com/spreadsheets/d/".$file['id']."/export?format=xlsx";
                break;

            case self::FILE_TYPE_DOCUMENT:
                $exportURL = "https://docs.google.com/document/d/".$file['id']."/export?format=docx";
                break;

            case self::FILE_TYPE_PRESENTATION:
                $exportURL = "https://docs.google.com/presentation/d/".$file['id']."/export/pptx";
                break;
            default:
                $exportURL = '';
                break;
        }
        return $exportURL;
    }

    public function getExportMymeType($file)
    {
        $exportFormat = '';
        switch ($file->getMimeType()) {
            case self::FILE_TYPE_SPREADSHEET:
                $exportFormat = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                break;

            case self::FILE_TYPE_DOCUMENT:
                $exportFormat = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                break;

            case self::FILE_TYPE_PRESENTATION:
                $exportFormat = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
                break;
            default:
                $exportFormat = '';
                break;
        }
        return $exportFormat;
    }

    public function convertGoogleDoc($file, $exportFolderId)
    {
        try {
            $exporting_file = new \Google_Service_Drive_DriveFile();
            $exporting_file->setName($file['name']);
            $exporting_file->setParents([$exportFolderId]);
            $exporting_file->setProperties(
                ["modifiedTimeOfOriginalFile" => date('Y-m-d H:i:s', strtotime($file['modifiedTime']))]
            );
            $content = null;
            $exporting_file->setMimeType($this->getExportMymeType($file));
            if ($this->getExportUrl($file)) {
                $httpClient = $this->client->authorize();
                $request = new GizzleRequest('GET' , $this->getExportUrl($file));
                $response = $httpClient->send($request);

                if ($response->getStatusCode() == 200) {
                    $content = file_get_contents($this->getExportUrl($file));
                }
            }
            $exported_file = $this->drive->files->create($exporting_file, array(
                'data' => $content,
                'uploadType' => 'multipart',
                'fields' => 'id, name, modifiedTime, iconLink, webViewLink, parents, fileExtension, mimeType, size, webContentLink, properties',
            ));
            return $exported_file;
        } catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
    }
    public  function  createExportFolder($parents, $folderName)
    {
        $exported_folder = null;
        $folder = new \Google_Service_Drive_DriveFile();
        $folder->setName($folderName);
        $folder->setParents($parents);
        $folder->setMimeType('application/vnd.google-apps.folder');
        $exported_folder = $this->drive->files->create($folder);
        return $exported_folder;
    }
    public function getExportFolderId($file_parent_id, $exportingFolderName)
    {
        $optParams = [
            'q' => "name = '" . $exportingFolderName . "' and  '" . $file_parent_id . "'  in parents and trashed = false and mimeType = 'application/vnd.google-apps.folder'",
            'fields' => 'files(id, name, modifiedTime, iconLink, webViewLink, parents, properties, fileExtension, mimeType, size, webContentLink, exportLinks)',
            "includeItemsFromAllDrives" => true,
            "supportsAllDrives" => true
        ];
        $result_query = $this->drive->files->listFiles($optParams);
        $folder = $result_query->getFiles();

        if (count($folder) > 0) {
            return $folder[0]['id'];
        }
    }
    public function checkExistsExportFolder($file_parent_id, $exportingFolderName)
    {
        $flagFolderExist = true;
        $optParams = [
            'q' => "name = '" . $exportingFolderName . "' and  '" . $file_parent_id . "'  in parents and trashed = false and mimeType = 'application/vnd.google-apps.folder'",
            'fields' => 'files(id, name, modifiedTime, iconLink, webViewLink, parents, properties, fileExtension, mimeType, size, webContentLink, exportLinks)',
            "includeItemsFromAllDrives" => true,
            "supportsAllDrives" => true
        ];
        $result_query = $this->drive->files->listFiles($optParams);
        if (!$result_query['files']) {
            $flagFolderExist = false;
        }

        return $flagFolderExist;
    }
    public function checkExportFileInExportFolder($exportFolderId, $filename)
    {
        $FileIsExists = true;

        $optParams = [
            'q' => " '" . $exportFolderId . "'  in parents and name = '" . $filename . "' and trashed = false",
            'fields' => 'files(id, name, modifiedTime, iconLink, webViewLink, parents, properties, fileExtension, mimeType, size, webContentLink, exportLinks)',
            "includeItemsFromAllDrives" => true,
            "supportsAllDrives" => true
        ];

        $result_query = $this->drive->files->listFiles($optParams);

        if (!$result_query['files']) {
            $FileIsExists = false;
        }

        return $FileIsExists;
    }
    public function checkModifiedTimeOfOriginalFile($exportFolderId, $file, $filename)
    {
        $DocIsModified = true;

        $optParams = [
            'q' => " '" . $exportFolderId . "'  in parents and name = '" . $filename . "' and trashed = false",
            'fields' => 'files(id, name, modifiedTime, iconLink, webViewLink, parents, properties, fileExtension, mimeType, size, webContentLink, exportLinks)',
            "includeItemsFromAllDrives" => true,
            "supportsAllDrives" => true
        ];

        $result_query = $this->drive->files->listFiles($optParams);

        foreach ($result_query as $exp_file) {
            if ($exp_file['properties']["modifiedTimeOfOriginalFile"] == date('Y-m-d H:i:s', strtotime($file['modifiedTime']))) {
                $DocIsModified = false;
            }
        }

        return $DocIsModified;
    }

    public function updateDocInExportFolder($parentFolder_id, $filename)
    {
        $optParams = [
            'q' => " '" . $parentFolder_id . "'  in parents and name = '" . $filename . "' and trashed = false",
            'fields' => 'files(id, name, modifiedTime, iconLink, webViewLink, parents, properties, fileExtension, mimeType, size, webContentLink, exportLinks)',
        ];
        $files = $this->drive->files->listFiles($optParams);



        foreach ($files as $file) {


            $response = $this->drive->files->get($file['id'], array(
                'alt' => 'media'));
            $content = $response->getBody()->getContents();
            $newfile = new \Google_Service_Drive_DriveFile();
            $newfile->setName($file['name']);
            $newfile->setProperties(["modifiedTimeOfOriginalFile" => date('Y-m-d H:i:s', strtotime($file['modifiedTime']))]);
            $updated_file = $this->drive->files->update($file['id'], $newfile, array(
                "uploadType" => "multipart",
                "data" => $content
            ));
        }
    }

    public function  getFilesWithPermissions ($email) {
        $pageToken = NULL;
        $result = array();
        do {
            try {
                $parameters = array();
                $parameters['fields'] = 'files(id, name, modifiedTime, iconLink, webViewLink, parents, properties, fileExtension, mimeType, size, webContentLink, exportLinks,  permissions)';
                $parameters['q'] = " ('" . $email . "'  in writers or '" . $email . "' in readers)  and trashed = false";
                $parameters['supportsAllDrives'] = true;
                $parameters['includeItemsFromAllDrives'] = true;
                if ($pageToken) {
                    $parameters['pageToken'] = $pageToken;
                }
                $files = $this->drive->files->listFiles($parameters);
                $result = array_merge($result, $files->getFiles());
                $pageToken = $files->getNextPageToken();
            } catch (Exception $e) {
                print "An error occurred: " . $e->getMessage();
                $pageToken = NULL;
            }
        } while ($pageToken);

        $files_array = [];

        foreach ($result as $key => $file) {
            if ($file['permissions'] == null) {

                $file->setPermissions("emailAddress" );

            }

            $files_array[$key] = [
                'id' => $file['id'],
                'name' => $file['name'],
                'icon' => $file['iconLink'],
                'permissions' => $file['permissions'],
                'modifiedTime' => date('Y-m-d H:i:s', strtotime($file['modifiedTime'])),
                'parentIds' => $file['parents'],
                'type' => $file['mimeType'],
                'size' => $file['size'],
                'webviewLink' => $file['webViewLink'],
                'webContentLink' => $file['webContentLink']
            ];
        }
        $response = [
            'success' => true,
            'data' => $files_array
        ];

        return response()->json($response, 200);
    }
}
