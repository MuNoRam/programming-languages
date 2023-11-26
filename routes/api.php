<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepotOwner;
use App\Http\Controllers\Pharmacist;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/Login' , [DepotOwner::class , 'Login'])->middleware('Login'); // $request is required (Header)
Route::post('/Add' , [DepotOwner::class , 'add_product']); // Request Body is required
Route::get('/search' , [DepotOwner::class , 'search']); // Query string is required
Route::get('/details' , [DepotOwner::class , 'details']); // query string is required
Route::post('/orders' , [DepotOwner::class , 'orders_show']);
Route::post('/order_modify' , [DepotOwner::class , 'order modify']); // Query string and Request Body are required

Route::post('/Add_order' , [Pharmacist::class , 'order']); // Query string and Request Body are required
Route::get('/show_orders' , [Pharmacist::class , 'show_orders']); // Query string is required
Route::get('/search_pharmacist' , [Pharmacist::class , 'search']); // Query string is required
Route::get('/details' , [Pharmacist::class , 'details']); // Query string is required
