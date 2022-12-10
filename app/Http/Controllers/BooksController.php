<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use resources\views\frontend\pages\books;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\BookAuthor;
//use App\Http\Controllers\Controller;

use Auth;

class BooksController extends Controller
{
    public function show($slug)
    {
        $book = Book::where('slug', $slug)->first();

        if (!is_null($book)) {
            return view('frontend.pages.books.show', compact('book'));
        }
        return redirect()->route('index');
    }


    public function create()
    {
        $categories = Category::all();
        $publishers = Publisher::all();
        $books = Book::where('is_approved', 1)->get();
        $authors = Author::all();

        return view('frontend.pages.books.create', compact('categories', 'publishers', 'authors', 'books'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {

            abort('403', 'Unauthorized action');
        }

        $this->validate(
            $request,
            [
                'title' => 'required|max:50',
                'category_id' => 'required',
                'publisher_id' => 'required',
                'slug' => 'nullable|unique:books',
                'description' => 'nullable',
                'image' => 'required|image|max:2048'
            ],
            [
                'title.required' => 'Please give book Title',
                'image.max' => 'Image Size can not be greater than 2MB'
            ]
        );


        $book = new Book();
        $book->title = $request->title;
        if (empty($request->slug)) {
            $book->slug = str::slug($request->title);
        } else {
            $book->slug = $request->slug;
        }

        $book->category_id = $request->category_id;
        $book->publisher_id = $request->publisher_id;
        $book->publish_year = $request->publish_year;
        $book->description = $request->description;
        $book->user_id = Auth::id();
        $book->is_approved = 1;
        $book->isbn = $request->isbn;
        $book->translator_id = $request->translator_id;


        $book->save();

        //Image Upload
        if ($request->image) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $name = time() . '-' . $book->id . '.' . $ext;
            $path = 'images/books';
            $file->move($path, $name);
            $book->image = $name;
            $book->save();
        }

        //Book Author
        foreach ($request->author_ids as $id) {
            $book_author = new BookAuthor();
            $book_author->book_id = $book->id;
            $book_author->author_id = $id;
            $book_author->save();
        }


        Session()->flash('success', 'Book has been created!!');
        return redirect()->route('index');
    }
}
