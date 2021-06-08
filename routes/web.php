<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/dashboard', 'AdminTaskController@index')->name('dashboard');

Route::get('/requestedTasks', 'AdminTaskController@displayClaimRequests')->name('tasks.requested');
Route::get('/task/create','AdminTaskController@create')->name('task.create');
Route::post('/task/store','AdminTaskController@store')->name('task.store');

Route::get('/task/edit/{id}','AdminTaskController@edit')->name('task.edit');
Route::put('/task/update/{id}','AdminTaskController@update')->name('task.update');

Route::put('/responde', 'AdminTaskController@respondeToClaimRequest')->name('claim.responde');

Route::put('/deliverable', 'DeliverableController@respondToDeliveryRequest')->name('deliverable.responde');
Route::get('/deliverable/download/{id}', 'DeliverableController@download')->name('deliverable.download');


Route::get('/deliverable', 'DeliverableController@index')->name('deliverables.requested');



//------------------For user-------------------------
Route::get('/tasks', 'UserTaskController@index')->name('user.index');

Route::get('/deliverable/create', 'DeliverableController@create');
Route::post('/deliverable', 'DeliverableController@store')->name('deliverable.store');


Route::put('/task/updateProgress','UserTaskController@updateProgress')->name('update.progress');

Route::get('/tasks/user', 'UserTaskController@taskHistory');
Route::put('/task','UserTaskController@makeClaimRequest')->name('task.claim');

Route::post('/comment', 'CommentController@makeComment')->name('add.comment');
Route::get('/comment/{id}', 'CommentController@returnComments')->name('task.view');