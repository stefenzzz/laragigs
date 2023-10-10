<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing 

//=========================== Manage Listings ===========================

// Show All Listings
Route::get('/', [ListingController::class,'index']);

// Manage listings
Route::get('/listings/manage',[ListingController::class,'manage'])->middleware('auth');

// Show Single Listing
Route::get('/listings/{listing}',[ListingController::class,'show']);

//Show Create Form
Route::get('/listings',[ListingController::class,'create'])->middleware('auth');

// Store Listing data
Route::post('/listings',[ListingController::class,'store'])->middleware('auth');

// Show Edit Form
Route::get('/listings/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');

// Update Listing
Route::put('/listings/{listing}',[ListingController::class,'update'])->middleware('auth');

// Update Listing
Route::delete('/listings/{listing}',[ListingController::class,'destroy'])->middleware('auth');



//=========================== User Routes ===========================

// Show register form
Route::get('/register',[UserController::class,'create'])->middleware('guest');

// Register a new user
Route::post('/register',[UserController::class,'store'])->middleware('guest');

//Show Login Form
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');

//Login the user
Route::post('/login',[UserController::class,'auth'])->middleware('guest');

//Logout User
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');




Route::get('/tests',function(){
   
    $user = User::query()->where('name','like','%stephen cabs%')->first();
    echo '<pre>';
    print_r($user->listings()->first()->title);
});


Route::get('/home/{id}', function ($e) {
    ddd($e);
    return $e;
})->where('id','[0-9]+');

Route::get('search',function(Request $e){
    dd($e->query());
});

Route::get('/test/{id}/{name}',function($id,$name){
    echo $id .' = '. $name;
}); 
