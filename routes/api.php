<?php

use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    // ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::prefix('movies')
            ->group(function () {
                Route::get('/', [MovieController::class, 'index'])->name('movieList');
                Route::post('/', [MovieController::class, 'store'])->name('movieStore');
                Route::get('/{movie}', [MovieController::class, 'show'])->name('movieShow');
                Route::put('/{movie}', [MovieController::class, 'update'])->name('movieUpdate');
                Route::delete('/{movie}', [MovieController::class, 'destroy'])->name('movieDestroy');
            });

        Route::prefix('genres')
            ->group(function () {
                Route::get('/', [GenreController::class, 'index'])->name('genreList');
            });

        // Route::get('/user', function (Request $request) {
        //     return $request->user();
        // });
    });

// Route::post('/tokens/create', function (Request $request) {
//     $token = $request->user()->createToken($request->token_name);

//     return ['token' => $token->plainTextToken];
// });
