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




    public function getFiles($parent_id)
    {

        $optParams = [
            'q'=> " '".$parent_id."'  in parents",
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
        $response = [
            'success'=> true,
            'data'=> $files_array
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
}
