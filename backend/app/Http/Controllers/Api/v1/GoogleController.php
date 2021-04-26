<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Google;
use Carbon\Carbon;

use Illuminate\Session;

class GoogleController extends Controller
{
    private $client;
    private $drive;

    public function __construct(Google $google, Request $request)
    {
        $this->client = $google->client();
        $this->client->setAccessToken($request->session()->get('user.token'));
        $this->drive = $google->drive($this->client);
    }

    public  function  getFilesFromDrive($parent_id) {
        $optParams = [
            'q'=> " '".$parent_id."'  in parents and trashed = false",
            'fields'=> 'files(id, name, modifiedTime, iconLink, webViewLink, parents, fileExtension, mimeType, size, webContentLink)',
            "includeItemsFromAllDrives"=> true,
            "supportsAllDrives"=> true
        ];
        $result_query = $this->drive->files->listFiles($optParams);

        $files = $result_query->getFiles();

        $files_array = [];

        foreach ($files as $key=>$file) {
            $files_array[$key] = [
                'id'=> $file['id'],
                'name' => $file['name'],
                'icon' => $file['iconLink'],
                'modifiedTime'=> date('Y-m-d H:i:s', strtotime($file['modifiedTime'])),
                'parentIds'=> $file['parents'],
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
            'success'=> true,
            'data'=> $this->getFilesFromDrive($parent_id)
        ];

        return response()->json($response, 200);
    }

    public function getSharedDrives() {
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

    public function  exportToGoogleDrive($folderName) {

    }

    public  function  createExportFolder ($folderName, $directoryId) {
        $files = $this->getFilesFromDrive($directoryId);
        $export_folder = null;
        foreach ($files as $file) {
            if($file['name'] != $folderName && $file['type'] != 'application/vnd.google-apps.folder') {
                $file = new \Google_Service_Drive_DriveFile();
                $file->setName($folderName);
                $file->setMimeType('application/vnd.google-apps.folder');
                $export_folder = $this->drive->files->create($file);
                break;
            }
        }
        return $export_folder;
    }

}
