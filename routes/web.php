<?php

use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Room\CreationController;
use App\Http\Controllers\Room\ManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\Room\SearchController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/room/create', [CreationController::class, 'create'])->name('room.create');
    Route::post('/room', [CreationController::class, 'store'])->name('room.store');
    Route::get('/room/{room}', [CreationController::class, 'show'])->name('room.show');

    Route::get('/my-rooms', [ManagementController::class, 'index'])->name('my-room.index');

    Route::get('invitation/create', [InvitationController::class, 'create'])->name('invitation.create');
    Route::post('invite', [InvitationController::class, 'invitePerson'])->name('invite.person');
    Route::post('invite-link', [InvitationController::class, 'inviteGroup'])->name('invite.group');

    Route::get('invitation/accept', [InvitationController::class, 'accept'])->name('invitation.accept');
    Route::get('invitation/decline', [InvitationController::class, 'decline'])->name('invitation.decline');
    Route::get('invitation/cancel', [InvitationController::class, 'cancel'])->name('invitation.cancel');
});

require __DIR__.'/auth.php';
