<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\BookAuthor;
use App\Models\Publisher;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        return view('backend.layouts.pages.books.index', compact(
            'books'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $publishers = Publisher::all();
        $authors = Author::all();
        return view('backend.layouts.pages.books.create', compact(
            'categories',
            'publishers',
            'authors'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        $request->validate([
            'title' => 'required|max:50',
            'category_id' => 'required',
            'publisher_id' => 'required',
            'slug' => 'nullable|unique:books',
            'description' => 'nullable',
        ]);

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
        $book->is_approved = 1;
        $book->save();

        //Book Authors
        $book_author = new BookAuthor();
        $book_author->book_id = $book->id;
        $book_author->author_id = $request->author_id;
        $book_author->save();


        session()->flash('success', 'Book has been created');

        return redirect()->route('admin.books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Book::find($id);

        $request->validate([
            'name' => 'required|max:50',
            'slug' => 'nullable|unique:categories,slug,' . $category->id,
            'description' => 'nullable',
        ]);


        $category->name = $request->name;
        if (empty($request->slug)) {
            $category->slug = str::slug($request->name);
        } else {
            $category->slug = $request->slug;
        }
        $category->parent_id = $request->parent_id;
        $category->description = $request->description;
        $category->save();

        session()->flash('success', 'Book has been updated');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete all child category
        // $child_categories = Book::where('parent_id', $id)->get();
        // $child_categories->delete();
        // foreach ($child_categories as $child) {
        //    $child->delete();
        //}

        $category = Book::find($id);
        $category->delete();

        session()->flash('success', 'Book has been deleted');
        return back();
    }
}
