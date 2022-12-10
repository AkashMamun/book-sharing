<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function index()
    {

        //return view('welcome');
        //return view('frontend.layouts.app');
        return view('pages.index');
    }
}
