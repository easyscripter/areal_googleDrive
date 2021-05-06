<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Google;
use Carbon\Carbon;

use Illuminate\Session;
use PhpParser\Node\Stmt\TryCatch;

class GoogleController extends Controller
{
    private $client;
    private $drive;
    private $docs;

    public function __construct(Google $google, Request $request)
    {
        $this->client = $google->client();
        $token = $request->session()->get('access_token');
        $this->client->setAccessToken(json_encode($token));
        $this->drive = $google->drive($this->client);
        $this->docs = $google->docs($this->client);
    }

    public  function  getFilesFromParentFolder($parent_id)
    {
        $optParams = [
            'q' => " '" . $parent_id . "'  in parents and trashed = false",
            'fields' => 'files(id, name, modifiedTime, iconLink, webViewLink, parents, fileExtension, mimeType, size, webContentLink)',
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
                $parameters['fields'] = 'files(id, name, modifiedTime, iconLink, webViewLink, parents, shared, fileExtension, mimeType, size, webContentLink)';
                $parameters['q'] = "trashed = false";
                $paramters['includeItemsFromAllDrives'] = true;
                $parameters['supportsAllDrives']  = true;
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

        return $result;
    }

    public function  exportToGoogleDrive($folderName)
    {
        $files = $this->getAllFilesFromDrive();
        //$tree = $this->makeTree($files, '0AMyvxxX7olLcUk9PVA');

        foreach ($files as $file) {

            $googleDocIsExists = $this->checkExistsGoogleDoc($file);
            if ($file['parents'] != null && $googleDocIsExists['isExists'] && ($this->checkExistsExportFolder($file['parents'][0], $folderName) == false)) {
                $export_folder = $this->createExportFolder($file['parents'], $folderName);
                $this->convertGoogleDoc($file, $googleDocIsExists['extension'], $export_folder['id'], $folderName);
            } else if ($file['parents'] != null && $googleDocIsExists['isExists'] && ($this->checkExistsExportFolder($file['parents'][0], $folderName) == true)) {
                $this->convertGoogleDoc($file, $googleDocIsExists['extension'], $this->getExportFolderId($file['parents'][0], $folderName));
            }
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

    public function checkExistsGoogleDoc($file)
    {
        switch ($file['mimeType']) {
            case "application/vnd.google-apps.document":
                $arr = [
                    "isExists" => true,
                    "extension" => "document"
                ];
                return $arr;
                break;
            case "application/vnd.google-apps.spreadsheet":
                $arr = [
                    "isExists" => true,
                    "extension" => "spreadsheets"
                ];
                return $arr;
                break;
            case "application/vnd.google-apps.presentation":
                $arr = [
                    "isExists" => true,
                    "extension" => "presentation"
                ];
                return $arr;
                break;
            default:
                $arr = [
                    "isExists" => false,
                    "extension" => ""
                ];
                return $arr;
                break;
        }
    }
    public function convertGoogleDoc($file, $extension, $exportFolderId)
    {
        try {
            $exporting_file = new \Google_Service_Drive_DriveFile();
            $exporting_file->setName($file['name']);
            $format = '';
            switch ($extension) {
                case "document":
                    $exporting_file->setMimeType('application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                    $format = 'docx';
                    break;
                case "spreadsheets":
                    $exporting_file->setMimeType('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    $format = 'xlsx';
                    break;
                case "presentation":
                    $exporting_file->setMimeType('application/vnd.openxmlformats-officedocument.presentationml.presentation');
                    $format = 'ppt';
                    break;
            }
            $exporting_file->setParents([$exportFolderId]);

            $content = file_get_contents("https://docs.google.com/" . $extension . "/d/" . $file['id'] . "/export?format=" . $format);
            $exported_file = $this->drive->files->create($exporting_file, array(
                'data' => $content,
                'uploadType' => 'multipart',
                'fields' => 'id, name, modifiedTime, iconLink, webViewLink, parents, fileExtension, mimeType, size, webContentLink',
            ));
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
            'fields' => 'files(id, name, modifiedTime, iconLink, webViewLink, parents, fileExtension, mimeType, size, webContentLink)',
            "includeItemsFromAllDrives" => true,
            "supportsAllDrives" => true
        ];
        $result_query = $this->drive->files->listFiles($optParams);
        $folder = $result_query->getFiles();
        return $folder[0]['id'];
    }
    public function checkExistsExportFolder($file_parent_id, $exportingFolderName)
    {
        $flagFolderExist = true;
        $optParams = [
            'q' => "name = '" . $exportingFolderName . "' and  '" . $file_parent_id . "'  in parents and trashed = false and mimeType = 'application/vnd.google-apps.folder'",
            'fields' => 'files(id, name, modifiedTime, iconLink, webViewLink, parents, fileExtension, mimeType, size, webContentLink)',
            "includeItemsFromAllDrives" => true,
            "supportsAllDrives" => true
        ];
        $result_query = $this->drive->files->listFiles($optParams);
        if (!$result_query['files']) {
            $flagFolderExist = false;
        }

        return $flagFolderExist;
    }
}
