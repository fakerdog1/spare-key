<?php

use App\Http\Controllers\Api\UserSearchController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->name('api.')->group(function () {
    Route::get(
        'user/search',
        [UserSearchController::class, 'search']
    )->name('user.search');
});
