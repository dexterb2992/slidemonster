<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\User;
use App\Subscription;
use GuzzleHttp\Client;

class AdminController extends Controller
{

    public function users()
    {
        return User::paginate(10);
    }

    public function addFeatures()
    {
        //
    }

    public function snycSubscriptions()
    {
        //
    }
}
