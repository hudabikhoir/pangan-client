<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use DB;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = DB::table('users')->get();
        $comodities = DB::table('comodities')->get();
        $client = new Client(); //GuzzleHttp\Client
        $result = $client->get('http://localhost:8080/warehouse');
        $content = json_decode($result->getBody()->getContents());

        return view('admin.warehouse',['content' => $content, 'user' => $user, 'comodities' => $comodities]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Client();

        $input = $request->all();
        $apiRequest = $client->request('POST','http://localhost:8080/warehouse', [
            'form_params' => [
                'id_user' => $input['id_user'],
                'id_comodities' => $input['id_comodities'],
                'stock' => $input['stock']
            ]
        ]);     
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
        $client = new Client();
        $apiRequest = $client->request('GET', 'http://localhost:8080/warehouse/'.$id, []);
        $content = $apiRequest->getBody()->getContents();

        return $content;
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
        $client = new Client();
 
        $input = $request->all();

        $apiRequest = $client->request('PUT', 'http://localhost:8080/warehouse/'.$id, [
            'form_params' => [
                // $input
                'id_user' => $input['id_user'],
                'id_comodities' => $input['id_comodities'],
                'stock' => $input['stock']
            ]
        ]);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = new Client();

        $apiRequest = $client->request('DELETE','http://localhost:8080/warehouse/'.$id, []);
    }
}
