<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request)
             //Acrescente as 3 linhas abaixo

            ->header('Access-Control-Allow-Origin', "*")
            ->header('Access-Control-Allow-Methods', "PUT, POST, DELETE, GET")
            ->header('Access-Control-Allow-Headers', "Accept, Authorization, Content-Type")
            ->header('x-access-token', "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJmZWVnb3ciLCJhdWQiOiJwdWJsaWNhcGkiLCJpYXQiOiIxNy0wOC0yMDE4IiwibGljZW5zZUlEIjoiMTA1In0.UnUQPWYchqzASfDpVUVyQY0BBW50tSQQfVilVuvFG38");
    }
}
