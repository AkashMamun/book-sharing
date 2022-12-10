<?php


use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\PagesController;
use App\Http\Controllers;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', 'PagesController@index');

Route::get('/', 'App\Http\Controllers\PagesController@index')->name('index');

Route::get('/books', 'App\Http\Controllers\BooksController@index')->name('books.index');
Route::get('/books/single-book', 'App\Http\Controllers\BooksController@show')->name('books.show');
//Route::get('/books/{slug}', 'App\Http\Controllers\BooksController@show')->name('books.show');

Route::get('/books/upload/new', 'App\Http\Controllers\BooksController@create')->name('books.upload');
Route::post('/books/upload/post', 'App\Http\Controllers\BooksController@store')->name('books.store');

Route::get('/books/categories/{slug}', 'App\Http\Controllers\CategoriesController@show')->name('categories.show');

Route::group(['prefix' => 'user'], function () {
    Route::get('/profile/{username}', 'App\Http\Controllers\UsersController@profile')->name('users.profile');
    Route::get('/profile/{username}/books', 'App\Http\Controllers\UsersController@profile')->name('users.books');
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', 'App\Http\Controllers\DashboardsController@index')->name('users.dashboard');

    Route::get('/books', 'App\Http\Controllers\DashboardsController@books')->name('users.dashboard.books');
});


Route::group(['prefix' => 'admin'], function () {
    Route::get('/admin', 'App\Http\Controllers\Backend\PagesController@index')->name('admin.index');

    Route::group(['prefix' => 'books'], function () {
        Route::get('/', 'App\Http\Controllers\Backend\BooksController@index')->name('admin.books.index');

        //Route::get('/{id}', 'App\Http\Controllers\Backend\BooksController@show')->name('admin.books.show');

        Route::get('/create', 'App\Http\Controllers\Backend\BooksController@create')->name('admin.books.create');

        Route::get('/edit/{id}', 'App\Http\Controllers\Backend\BooksController@edit')->name('admin.books.edit');

        Route::post('/store', 'App\Http\Controllers\Backend\BooksController@store')->name('admin.books.store');

        Route::post('/update/{id}', 'App\Http\Controllers\Backend\BooksController@update')->name('admin.books.update');
    });

    Route::group(['prefix' => 'authors'], function () {
        Route::get('/', 'App\Http\Controllers\Backend\AuthorsController@index')->name('admin.authors.index');
        Route::post('/store', 'App\Http\Controllers\Backend\AuthorsController@store')->name('admin.authors.store');
        Route::get('/{id}', 'App\Http\Controllers\Backend\AuthorsController@show')->name('admin.authors.show');
        Route::post('/update/{id}', 'App\Http\Controllers\Backend\AuthorsController@update')->name('admin.authors.update');
        Route::post('/delete/{id}', 'App\Http\Controllers\Backend\AuthorsController@destroy')->name('admin.authors.delete');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'App\Http\Controllers\Backend\CategoriesController@index')->name('admin.categories.index');
        Route::post('/store', 'App\Http\Controllers\Backend\CategoriesController@store')->name('admin.categories.store');
        Route::get('/{id}', 'App\Http\Controllers\Backend\CategoriesController@show')->name('admin.authors.show');
        Route::post('/update/{id}', 'App\Http\Controllers\Backend\CategoriesController@update')->name('admin.categories.update');
        Route::post('/delete/{id}', 'App\Http\Controllers\Backend\CategoriesController@destroy')->name('admin.categories.delete');
    });

    Route::group(['prefix' => 'publishers'], function () {
        Route::get('/', 'App\Http\Controllers\Backend\PublishersController@index')->name('admin.publishers.index');
        Route::post('/store', 'App\Http\Controllers\Backend\PublishersController@store')->name('admin.publishers.store');
        Route::get('/{id}', 'App\Http\Controllers\Backend\PublishersController@show')->name('admin.authors.show');
        Route::post('/update/{id}', 'App\Http\Controllers\Backend\PublishersController@update')->name('admin.publishers.update');
        Route::post('/delete/{id}', 'App\Http\Controllers\Backend\PublishersController@destroy')->name('admin.publishers.delete');
    });
});








//Route::get('/', function () {
//$name = '<b> akash <b>';
// return view('welcome', compact('name'));
// return 'Hello';
//});



Auth::routes(['verify' => true]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
