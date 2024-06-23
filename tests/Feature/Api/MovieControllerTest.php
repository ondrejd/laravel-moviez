<?php

namespace Tests\Feature\Api;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class MovieControllerTest extends TestCase
{
    public function test_list_movies(): void
    {
        $this
            ->sanctumActingAs(User::all()->first())
            ->get('/api/v1/movies')
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json
                    ->has(
                        '0',
                        fn (AssertableJson $json) => $json->hasAll([
                            'Id',
                            'Name',
                            'Description',
                            'Genres',
                            'Csfd',
                            'Imdb',
                        ])
                    );
            });
    }

    public function test_create_movie(): void
    {
        $this
            ->sanctumActingAs(User::all()->first())
            ->post('/api/v1/movies/', [
                'Name' => 'New movie',
                'Description' => 'Something...',
                'Genres' => Genre::select()->limit(2)->pluck('id')->toArray(),
                'Csfd' => 'https://www.csfd.cz/new-movie',
            ])
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json
                    ->hasAll([
                        'Id',
                        'Name',
                        'Description',
                        'Genres',
                        'Csfd',
                        'Imdb',
                    ])
                    ->where('Name', 'New movie')
                    ->where('Description', 'Something...')
                    ->where('Csfd', 'https://www.csfd.cz/new-movie')
                    ->where('Imdb', null)
                    ->has('Genres', 2)
                    ->has('Genres.0', function (AssertableJson $json) {
                        $json->hasAll(['Id', 'Name', 'Color']);
                    });
            });
    }

    public function test_show_movie(): void
    {
        $movieId = Movie::all()->pluck('id')->random();

        $this
            ->sanctumActingAs(User::all()->first())
            ->get('/api/v1/movies/'.$movieId)
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll([
                    'Id',
                    'Name',
                    'Description',
                    'Genres',
                    'Csfd',
                    'Imdb',
                ]);
            });
    }

    public function test_update_movie(): void
    {
        $movie = Movie::all()->random();

        $this
            ->sanctumActingAs(User::find($movie->user_id))
            ->put('/api/v1/movies/'.$movie->id, [
                'Name' => 'Updated movie',
                'Genres' => Genre::select()->limit(3)->pluck('id')->toArray(),
            ])
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json
                    ->hasAll([
                        'Id',
                        'Name',
                        'Description',
                        'Genres',
                        'Csfd',
                        'Imdb',
                    ])
                    ->where('Name', 'Updated movie')
                    ->has('Genres', 3)
                    ->has('Genres.0', function (AssertableJson $json) {
                        $json->hasAll(['Id', 'Name', 'Color']);
                    });
            });
    }

    public function test_delete_movie(): void
    {
        $movie = Movie::all()->random();

        $this
            ->sanctumActingAs(User::find($movie->user_id))
            ->delete('/api/v1/movies/'.$movie->id)
            ->assertStatus(200);
    }

    public function test_delete_movie_without_authorization(): void
    {
        $movie = Movie::all()->random();
        // Najdeme si uživatele, který určitě film nevytvářel
        $userIds = array_diff(User::all()->pluck('id')->toArray(), [$movie->user_id]);

        $this
            ->sanctumActingAs(User::find(array_pop($userIds)))
            ->delete('/api/v1/movies/'.$movie->id)
            ->assertStatus(403);
    }
}
