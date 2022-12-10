<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
//use App\Http\Controllers\Backend\str_slug;

use Illuminate\Support\Str;
use App\Models\Book;

use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\BookAuthor;

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
        return view('backend.pages.books.index', compact('books'));
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
        $books = Book::where('is_approved', 1)->get();
        $authors = Author::all();
        return view('backend.pages.books.create', compact('categories', 'publishers', 'authors', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        $book->user_id = 1;
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
        $book = Book::find($id);
        $categories = Category::all();
        $publishers = Publisher::all();
        $books = Book::where('is_approved', 1)->where('id', '!=', $id)->get();
        $authors = Author::all();
        return view('backend.pages.books.edit', compact('categories', 'publishers', 'authors', 'books', 'book'));
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

        /*
        $book = Book::find($id);

        $request->validate([
            'name' => 'required|max:50',
            'slug' => 'nullable|unique:books,slug' . $book->id,
            'description' => 'nullable',
        ]);


        $book->name = $request->name;
        if (empty($request->slug)) {
            $book->slug = str::slug($request->name);
        } else {
            $book->slug = $request->slug;
        }

        $book->parent_id = $request->parent_id;
        $book->description = $request->description;
        $book->save();


        Session()->flash('success', 'Book has been updated!!');
        return back();
        */
        $book =  Book::find($id);
        $this->validate(
            $request,
            [
                'title' => 'required|max:50',
                'category_id' => 'required',
                'publisher_id' => 'required',
                'slug' => 'nullable|unique:books,slug,' . $book->id,
                'description' => 'nullable',
                'image' => 'nullable|image|max:2048'
            ],
            [
                'title.required' => 'Please give book Title',
                'image.max' => 'Image Size can not be greater than 2MB'
            ]
        );



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
        // $book->user_id = 1;
        // $book->is_approved = 1;
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
        //Delete old Authors  Table Data
        $book_authors = BookAuthor::where('book_id', $book_id)->get();
        foreach ($book_authors as $author) {
            $author->delete();
        }

        foreach ($request->author_ids as $id) {
            $book_author = new BookAuthor();
            $book_author->book_id = $book->id;
            $book_author->author_id = $id;
            $book_author->save();
        }


        Session()->flash('success', 'Book has been created!!');
        return redirect()->route('admin.books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $child_books = Book::where('parent_id', $id)->get();

        foreach ($child_books as $child) {
            $child->delete();
        }
        $book = Book::find($id);
        $book->delete();


        Session()->flash('success', 'Book has been deleted!!');
        return back();
    }
}
