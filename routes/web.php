<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addEmployeeController;
use App\Http\Controllers\showEmployeeDetailsController;
use App\Http\Controllers\editEmployeeDetailsController;
use App\Http\Controllers\mailController;
use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\admin\settingsController;



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



/**
 * 
 *  Question PAGE Routes
 * 
 */

Route::get('/all-questions', [adminController::class, 'all_questions'])
                ->middleware(['auth', 'verified'])
                ->name('all-questions');


Route::get('/edit-question/{id}', [adminController::class, 'edit_question'])
                ->middleware(['auth', 'verified'])
                ->name('edit-question');


Route::put('/edit-question/{id}', [adminController::class, 'update_question'])
                ->middleware(['auth', 'verified'])
                ->name('update-question');

Route::get('/add_question', [adminController::class, 'add_question'])
                ->middleware(['auth', 'verified'])
                ->name('add_question');

Route::post('/add_question', [adminController::class, 'store_question']);Route::post('/add_question', [adminController::class, 'store_question'])
                ->middleware(['auth', 'verified'])
                ->name('add-questions');

Route::post('delete/question', [adminController::class, 'deleted_question']);

/**
 * 
 *  Game PAGE Routes
 * 
 */

Route::get('/create_game', [adminController::class, 'create_game'])
                ->middleware(['auth', 'verified'])
                ->name('create_game');

Route::post('/create_game', [adminController::class, 'store_game'])
                ->middleware(['auth', 'verified'])
                ->name('store_game');


Route::get('/all_games', [adminController::class, 'all_games'])
                ->middleware(['auth', 'verified'])
                ->name('all_games');

Route::get('/edit_game/{id}', [adminController::class, 'edit_game'])
                ->middleware(['auth', 'verified'])
                ->name('edit_game');

Route::put('/edit_game/{id}', [adminController::class, 'update_game'])
                ->middleware(['auth', 'verified'])
                ->name('update_game');

Route::post('/publish/game', [adminController::class, 'publish_game'])
                ->middleware(['auth', 'verified'])
                ->name('publish_game');

Route::post('delete/game', [adminController::class, 'delete_game']);


/**
 * 
 *  User PAGE Routes
 * 
 */

Route::get('/all_users', [adminController::class, 'all_users'])
                    ->middleware(['auth', 'verified'])
                    ->name('all_users');

//change user status
Route::get('/change_status/{id}', [adminController::class, 'change_status']);





require __DIR__.'/auth.php';
require __DIR__.'/setting_route.php';


?>
