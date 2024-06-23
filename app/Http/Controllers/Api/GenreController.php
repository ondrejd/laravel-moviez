<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Genre\GenreListRequest;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;

class GenreController extends Controller
{
    /**
     * Zobrazí seznam filmových žánrů.
     *
     * @param GenreListRequest $request
     * @return JsonResponse
     */
    public function index(GenreListRequest $request): JsonResponse
    {
        $genres = Genre::all();

        return response()->json($genres);
    }
}
