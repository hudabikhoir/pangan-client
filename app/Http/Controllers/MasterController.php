<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class MasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $client = new Client(); //GuzzleHttp\Client
        $result = $client->get('http://localhost:8080/category');
        $content = json_decode($result->getBody()->getContents());
        // dd($result->getBody()->getContents());
        return view('admin.master',['content' => $content]);
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
        // echo"hl";exit;
        $client = new Client();

        $input = $request->all();
        $apiRequest = $client->request('POST','http://localhost:8080/category', [
            'form_params' => [

                'name' => $input['name']
            ]
        ]);       
        
        // return redirect ('home');
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

        $apiRequest = $client->request('GET', 'http://localhost:8080/category/'.$id, []);
        
        $content = $apiRequest->getBody()->getContents();
        // $content = $content[0];
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

        $apiRequest = $client->request('PUT', 'http://localhost:8080/category/'.$id, [
            'form_params' => [
                // $input
                'name' => $input['name']
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

        $apiRequest = $client->request('DELETE','http://localhost:8080/category/'.$id, []);
    }

    public function getComodities($id){
        $client = new Client();

        $apiRequest = $client->request('GET', 'http://localhost:8080/comodities/'.$id, []);
        $content = $apiRequest->getBody()->getContents();
        
        return $content;
    }

    public function editComodities($id){
        $client = new Client();

        $apiRequest = $client->request('GET', 'http://localhost:8080/comodities/edit/'.$id, []);
        $content = $apiRequest->getBody()->getContents();
        
        return $content;
    }

    public function storeComodities(Request $request)
    {
        $client = new Client();

        $input = $request->all();
        $apiRequest = $client->request('POST','http://localhost:8080/comodities', [
            'form_params' => [
                'id_categories' => $input['id_categories'],
                'name' => $input['name']
            ]
        ]);       
        
        // return redirect ('home');
    }
    public function updateComodities(Request $request, $id)
    {
        $client = new Client();
 
        $input = $request->all();

        $apiRequest = $client->request('PUT', 'http://localhost:8080/comodities/'.$id, [
            'form_params' => [
                'id_categories' => $input['id_categories'],
                'name' => $input['name']
            ]
        ]);  
    }

    public function destroyComodities($id)
    {
        $client = new Client();

        $apiRequest = $client->request('DELETE','http://localhost:8080/comodities/'.$id, []);
    }
}
