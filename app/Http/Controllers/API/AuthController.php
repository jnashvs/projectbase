<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AuthController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth:api');
    }*/

    public function index()
    {
        return "yesss";
    }

    public function login(Request $request)
    {

        $http = new \GuzzleHttp\Client();

        try {

            $response = $http->post('http://localhost:8023/oauth/token', [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode([
                    'grant_type' => 'password',
                    'client_id' => 2,
                    'client_secret' => 'gcDJp0VNlMSSbGGCz7mkP2y86xkq46glWKVxBRlj',
                    'username' => $request->username,
                    'password' => $request->password                ])
                    ,
                    'timeout' => 5

            ]);

           /* $response = $http->post('http://192.168.1.83:8020/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => 2,
                    'client_secret' => 'gcDJp0VNlMSSbGGCz7mkP2y86xkq46glWKVxBRlj',
                    'username' => $request->username,
                    'password' => $request->password
                ]
            ]);*/

            return $request;

            //return $response->getBody();
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return response()->json('shitt', $e->getCode());
        }
    }
}
