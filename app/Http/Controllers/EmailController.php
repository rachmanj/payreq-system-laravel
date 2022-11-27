<?php

namespace App\Http\Controllers;

use App\Mail\NotificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index()
    {

        Mail::to("rachmanj@gmail.com")->send(new NotificationEmail());

        return "Email telah dikirim";
    }
}
