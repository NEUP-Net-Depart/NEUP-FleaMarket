<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\GoodInfo;

class ContentController extends Controller
{
    public function Mainpage()
    {
        return View::make('welcome');
    }
}
