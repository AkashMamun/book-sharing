<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use resources\views\frontend\pages\books;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\User;
use App\Models\BookAuthor;
//use App\Http\Controllers\Controller;

use Auth;

class UsersController extends Controller
{
    public function profile($username)
    {
        $user = User::where('username', $username)->first();

        if (!is_null($user)) {
            return view('frontend.pages.users.show', compact('user'));
        }
        return redirect()->route('index');
    }
    public function books($username)
    {
        $user = User::where('username', $username)->first();

        if (!is_null($user)) {
            $books = $user->books;
            return view('frontend.pages.users.books', compact('user', 'books'));
        }
        return redirect()->route('index');
    }
}
