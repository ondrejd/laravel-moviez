<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Tests\TestCase;

class MovieTest extends TestCase
{
    public function test_if_create_is_successfull(): void
    {
        $moviesCount = Movie::count();

        $newMovie = Movie::create([
            'user_id' => User::all()->random()->id,
            'name' => 'Robocop',
        ]);

        $this->assertModelExists($newMovie);

        $lastMovie = Movie::all()->last();

        $this->assertDatabaseCount('movies', $moviesCount + 1);
        $this->assertSame('Robocop', $lastMovie->name);
        $this->assertNull($lastMovie->description);
    }

    public function test_if_create_with_genres_is_successfull(): void
    {
        $moviesCount = Movie::count();

        $newMovie = Movie::create([
            'user_id' => User::all()->random()->id,
            'name' => 'Terminator',
        ]);
        $newMovie->genres()->attach(Genre::select()->limit(2)->pluck('id')->toArray());

        $this->assertModelExists($newMovie);

        $lastMovie = Movie::all()->last();

        $this->assertDatabaseCount('movies', $moviesCount + 1);
        $this->assertSame('Terminator', $lastMovie->name);
        $this->assertSame(2, $lastMovie->genres->count());
    }

    public function test_if_delete_is_successfull(): void
    {
        $moviesCount = Movie::count();
        $lastMovie = Movie::all()->last();

        $lastMovie->delete();

        $this->assertModelMissing($lastMovie);
        $this->assertDatabaseCount('movies', $moviesCount - 1);
    }
}
