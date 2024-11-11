<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

Route::get('/hello', function () {
    return response('<h1>Hello world</h1>', 200)
        ->header('Content-Type', 'text/plain');
});

Route::get('/posts/{id}', function ($id) {
    return response('Post ' . $id);
})->where('id', '[0-9]+');

Route::get('/search', function (Request $request) {
    return $request->name . ' ' . $request->city;
});

//LISTING ROUTES
// show all listings
Route::get('/listings', [ListingController::class, 'index']);

//show the form to create a new listing
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth')->middleware('auth');

//store the new listing
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//show the form to edit a listing
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//Update the listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Delete the listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//show a single listing
Route::get('/listing/{listing}', [ListingController::class, 'show']);

//USER ROUTES
//show Register/Create form
Route::get('/register', [UserController::class, 'create']);

//Create a new user
Route::post('/users', [UserController::class, 'store']);

//Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//Show Login form
Route::get('/login', [UserController::class, 'login'])->name('login');

//Log User In
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

// Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');



// Common Resource Routes:
// index - Show all listings
// create - Show a form to create a new listing
// store - Store(Save) the new listing
// show - Show a single listing
// edit - Show a form to edit a listing
// update - Update the listing
// destroy - Delete the listing


// GET - Cette méthode est utilisée pour demander des données à partir d'une ressource spécifiée. Les routes GET sont utilisées pour récupérer des données. Par exemple, récupérer les détails d'un utilisateur ou afficher un article de blog.

// POST - Cette méthode est utilisée pour envoyer des données à un serveur pour créer une nouvelle ressource. Les routes POST sont utilisées pour créer de nouvelles ressources. Par exemple, créer un nouvel utilisateur ou ajouter un article à un blog.

// PUT - Cette méthode est utilisée pour mettre à jour une ressource spécifiée. Les routes PUT sont utilisées pour mettre à jour des ressources existantes. Par exemple, mettre à jour les détails d'un utilisateur existant.

// DELETE - Cette méthode supprime une ressource spécifiée. Les routes DELETE sont utilisées pour supprimer des ressources. Par exemple, supprimer un utilisateur existant.



