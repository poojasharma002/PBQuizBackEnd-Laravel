<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\addEmployeeController;
use App\Http\Controllers\showEmployeeDetailsController;
use App\Http\Controllers\editEmployeeDetailsController;
use App\Http\Controllers\mailController;
use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\admin\settingsController;

/**
 * 
 *  Tag Routes
 * 
 */
Route::get('/add_tag', [settingsController::class, 'add_tag'])
                ->middleware(['auth', 'verified'])
                ->name('add_tag');

Route::post('/add_tag', [settingsController::class, 'store_tag'])
                ->middleware(['auth', 'verified'])
                ->name('store_tag');

Route::put('/edit_tag', [settingsController::class, 'edit_tag'])
                ->middleware(['auth', 'verified'])
                ->name('edit_tag');

Route::post('/delete_tag', [settingsController::class, 'destroy_tag'])
                ->middleware(['auth', 'verified'])
                ->name('destroy_tag');


/**
 * 
 *  Host  Routes
 * 
 */
Route::get('/add_host', [settingsController::class, 'add_host'])
                ->middleware(['auth', 'verified'])
                ->name('add_host');

Route::post('/add_host', [settingsController::class, 'store_host'])
                ->middleware(['auth', 'verified'])
                ->name('store_host');


Route::put('/edit_host', [settingsController::class, 'edit_host'])
                ->middleware(['auth', 'verified'])
                ->name('edit_host');

Route::post('/delete_host', [settingsController::class, 'destroy_host'])
                ->middleware(['auth', 'verified'])
                ->name('destroy_host');

/**
 * 
 *  Music Routes
 * 
 */
Route::get('/add_music', [settingsController::class, 'add_music'])
                ->middleware(['auth', 'verified'])
                ->name('add_music');

Route::post('/add_music', [settingsController::class, 'store_music'])
                ->middleware(['auth', 'verified'])
                ->name('store_music');

/**
 * 
 *  Trophy Routes
 * 
 */

Route::get('/add_trophy', [settingsController::class, 'add_trophy'])
                ->middleware(['auth', 'verified'])
                ->name('add_trophy');

Route::post('/add_trophy', [settingsController::class, 'store_trophy'])
                ->middleware(['auth', 'verified'])
                ->name('store_trophy');

Route::put('/edit_trophy', [settingsController::class, 'edit_trophy'])
                ->middleware(['auth', 'verified'])
                ->name('edit_trophy');

Route::post('/delete_trophy', [settingsController::class, 'delete_trophy'])
                ->middleware(['auth', 'verified'])
                ->name('destroy_trophy');

/**
 * 
 *  Select Featured Game Routes
 * 
 */

 Route::get('/select_featured_game', [settingsController::class, 'select_featured_game'])
                ->middleware(['auth', 'verified'])
                ->name('select_featured_game');

Route::post('/select_featured_game', [settingsController::class, 'store_featured_game'])
                ->middleware(['auth', 'verified'])
                ->name('store_featured_game');

?>