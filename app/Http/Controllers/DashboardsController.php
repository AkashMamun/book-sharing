<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use Auth;
use Illuminate\Http\Request;

class DashboardsController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if (!is_null($user)) {
            return view('frontend.pages.users.dashboard', compact('user'));
        }
        return redirect()->route('index');
    }

    public function books()
    {
        $user = Auth::user();


        if (!is_null($user)) {
            $books = $user->books;
            return view('frontend.pages.users.dashboard_books', compact('user', 'books'));
        }
        return redirect()->route('index');
    }
}
