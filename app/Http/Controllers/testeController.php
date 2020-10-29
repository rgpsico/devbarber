<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class testeController extends Controller{
public function teste(){
    $url = 'https://api.feegow.com/v1/api/professional/list?especialidade_id=263';
    $request_url = $url;
    $curl = curl_init($request_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'X-RapidAPI-Host: kvstore.p.rapidapi.com',
        'x-access-token:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJmZWVnb3ciLCJhdWQiOiJwdWJsaWNhcGkiLCJpYXQiOiIxNy0wOC0yMDE4IiwibGljZW5zZUlEIjoiMTA1In0.UnUQPWYchqzASfDpVUVyQY0BBW50tSQQfVilVuvFG38 ',
        'Content-Type:application/json'
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    echo $response;
     }
}



?>