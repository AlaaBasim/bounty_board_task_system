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


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>['auth', 'isAdmin']], function(){
    Route::get('/dashboard', 'AdminTaskController@index')->name('dashboard');
    Route::get('/task/create','AdminTaskController@create')->name('task.create');
    Route::post('/task/store','AdminTaskController@store')->name('task.store');
    Route::get('/task/{id}','AdminTaskController@edit')->name('task.edit');
    Route::put('/task/{id}','AdminTaskController@update')->name('task.update');

    Route::get('/claim/requests', 'AdminTaskController@displayClaimRequests')->name('tasks.requested');
    Route::get('/deliverable/requests', 'DeliverableController@index')->name('deliverables.requested');

    Route::put('/claim/respond', 'AdminTaskController@respondeToClaimRequest')->name('claim.responde');
    Route::put('/deliverable/respond', 'DeliverableController@respondToDeliveryRequest')->name('deliverable.responde');

    Route::get('/deliverable/download/{id}', 'DeliverableController@download')->name('deliverable.download');
});



//------------------For user-------------------------
Route::group(['middleware'=>'auth'], function(){
    Route::get('/tasks', 'UserTaskController@index')->name('user.index');

    Route::get('/deliverable/create/{id}', 'DeliverableController@create')->name('deliverable.create');
    Route::post('/deliverable', 'DeliverableController@store')->name('deliverable.store');


    Route::put('/task/updateProgress','UserTaskController@updateProgress')->name('update.progress');

    Route::get('/tasks/history', 'UserTaskController@taskHistory')->name('tasks.history');
    Route::put('/task','UserTaskController@makeClaimRequest')->name('task.claim');

    Route::post('/comment', 'CommentController@makeComment')->name('add.comment');
    Route::get('/comment/{id}', 'CommentController@returnComments')->name('task.view');
});