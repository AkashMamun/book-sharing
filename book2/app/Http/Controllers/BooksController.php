<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use resources\views\pages\books;
use App\Models\Book;

class BooksController extends Controller
{
    public function show()
    {
        return view('pages.books.show');
    }
}
