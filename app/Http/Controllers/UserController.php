<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use DB;
class UserController extends Controller
{
    public function index(){
        $client = new Client(); //GuzzleHttp\Client
        $result = $client->get('localhost:8080/user');
        $content = json_decode($result->getBody()->getContents());
        // dd($result->getBody()->getContents());
        return view('admin.user',['content' => $content]);
    }

    public function store(Request $request){
        $client = new Client();
        $input = $request->all();
        $apiRequest = $client->request('POST','http://localhost:8080/register', [
            'form_params' => [
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => $input['password'],
                'id_role' => $input['id_role'],
            ]
        ]);
    }

    public function edit($id){
        $client = new Client();
        $apiRequest = $client->request('GET', 'http://localhost:8080/user/'.$id, []);      
        $content = $apiRequest->getBody()->getContents();
        // $content = $content[0];
        return $content;
    }

    public function destroy($id){
        $user = DB::table('users')->where('id', $id)->delete();
        return $user;
    }
}
