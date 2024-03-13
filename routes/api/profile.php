<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\OptionalAuthenticate;
use Illuminate\Support\Facades\Route;

Route::prefix('profiles')->group(function () {
    Route::middleware([OptionalAuthenticate::class])
        ->get('', [ProfileController::class, 'index'])->name('index');
    Route::middleware(['auth:sanctum'])
        ->post('', [ProfileController::class, 'store'])->name('store');
    Route::middleware(['auth:sanctum'])
        ->post('{profile_id}/comments', [CommentController::class, 'store'])->name('storeComment');
    Route::middleware(['auth:sanctum'])
        ->get('{profile_id}/comments', [CommentController::class, 'listForProfile'])->name('listComments');
});
