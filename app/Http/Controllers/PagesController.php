<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Book;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('frontend.pages.index', compact('books'));
    }
}
