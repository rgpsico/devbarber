<?php

namespace App\Http\Controllers;

use App\Mail\SendMailUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function send(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        Mail::to('test@email.com')->send(new SendMailUser($name, $email));
    }
}
