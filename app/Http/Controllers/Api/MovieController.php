<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Movie\MovieDestroyRequest;
use App\Http\Requests\Movie\MovieListRequest;
use App\Http\Requests\Movie\MovieShowRequest;
use App\Http\Requests\Movie\MovieStoreRequest;
use App\Http\Requests\Movie\MovieUpdateRequest;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    /**
     * Zobrazí seznam filmů.
     *
     * @param  MovieStoreRequest  $request
     *
     * @todo Přidat základní filtrování a stránkování.
     */
    public function index(MovieListRequest $request): JsonResponse
    {
        $movies = Movie::all();
        //->where('user_id', $user->id)

        return response()->json($movies);
    }

    /**
     * Vytvoří nový film.
     */
    public function store(MovieStoreRequest $request): JsonResponse
    {
        $data = $request->toArray();

        $movie = Movie::create([
            /**
             * @todo Tuto věcičku s uživatelem dokončit !!!
             */
            'user_id' => User::all()->random()->id,
            'name' => $data['Name'],
            'description' => isset($data['Description']) ? $data['Description'] : null,
            'csfd' => isset($data['Csfd']) ? $data['Csfd'] : null,
            'imdb' => isset($data['Imdb']) ? $data['Imdb'] : null,
        ]);

        if (isset($data['Genres']) && is_array($data['Genres'])) {
            $movie->genres()->attach($data['Genres']);
        }

        return response()->json($movie);
    }

    /**
     * Zobrazí vybraný film.
     */
    public function show(MovieShowRequest $request, Movie $movie): JsonResponse
    {
        return response()->json($movie);
    }

    /**
     * Aktualizuje vybraný film.
     */
    public function update(MovieUpdateRequest $request, Movie $movie): JsonResponse
    {
        $data = $request->toArray();

        $movie->name = $data['Name'];

        if (isset($data['Description'])) {
            $movie->description = $data['Description'];
        }

        if (isset($data['Csfd'])) {
            $movie->csfd = $data['Csfd'];
        }

        if (isset($data['Imdb'])) {
            $movie->imdb = $data['Imdb'];
        }

        if (isset($data['Genres'])) {
            $movie->genres()->detach();

            if (is_array($data['Genres'])) {
                $movie->genres()->attach($data['Genres']);
            }
        }

        $movie->save();

        return response()->json($movie->refresh());
    }

    /**
     * Smaže vybraný film.
     */
    public function destroy(MovieDestroyRequest $request, Movie $movie): JsonResponse
    {
        $movie->delete();

        return response()->json();
    }
}
