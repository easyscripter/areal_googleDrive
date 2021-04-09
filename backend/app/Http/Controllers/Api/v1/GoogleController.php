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
        $this->client->setAccessToken($request->session()->get('auth_token'));
        $this->drive = $google->drive($this->client);
    }




    public function getFiles($parent_id)
    {   
        
        $optParams = [
            'q'=> " '".$parent_id."'  in parents",
            'fields'=> 'files(id, name, modifiedTime, iconLink, webViewLink, parents, fileExtension, mimeType, size, webContentLink)'
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
