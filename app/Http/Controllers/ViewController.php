<?php

namespace App\Http\Controllers;

use Activation;
use App\Http\Requests\FrontendRequest;
use File;
use Hash;
use Mail;
use Redirect;
use Reminder;
use Validator;
use Sentinel;
use URL;
use View;


class ViewController extends BasicController
{
    public function showView($name=null)
    {
        if(View::exists($name))
        {
            return view($name);
        }
        else
        {
            abort('404');
        }
    }
}
