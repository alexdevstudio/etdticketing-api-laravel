<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'Auth\RegisterController@create');
Route::post('activate', 'Auth\ActivationController@activate');
Route::get('geo_locations', 'AddressController@getAll');
Route::get('floors/{floor_address_id}', 'FloorController@getAll');
Route::get('offices/{office_address_id}', 'OfficeController@getAll');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->post('/submitTicket', 'TicketController@submit');
Route::middleware('auth:api')->post('/postReply', 'ReplyController@submit');
Route::middleware('auth:api')->get('/getPendingTickets/{ticket_user_id}', 'TicketController@getPendingTickets');
Route::middleware('auth:api')->get('/getTicket/{ticket_id}', 'TicketController@getTicket');
Route::middleware('auth:api')->get('/getCompletedTickets/{ticket_user_id}', 'TicketController@getCompletedTickets');
