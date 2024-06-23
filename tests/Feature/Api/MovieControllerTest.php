<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class MovieControllerTest extends TestCase
{
    public function test_list_movies(): void
    {
        $this
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
            ->get('/api/v1/movies/' . $movieId)
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
        $movieId = Movie::all()->pluck('id')->random();

        $this
            ->put('/api/v1/movies/' . $movieId, [
                'Name' => 'Updated movie',
                'Genres' => Genre::select()->limit(3)->pluck('id')->toArray()
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
        $movieId = Movie::all()->pluck('id')->random();

        $this
            ->delete('/api/v1/movies/' . $movieId)
            ->assertStatus(200);
    }
}
