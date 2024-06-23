<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Tests\TestCase;

class GenreTest extends TestCase
{
    public function test_if_seed_was_executed(): void
    {
        $this->assertDatabaseCount('genres', 10);
    }

    public function test_if_create_is_successfull(): void
    {
        $newGenre = Genre::create(['name' => 'Test genre', 'color' => 'blue']);

        $this->assertModelExists($newGenre);
        $this->assertDatabaseCount('genres', 11);

        $lastGenre = Genre::all()->last();

        $this->assertSame('Test genre', $lastGenre->name);
        $this->assertSame('blue', $lastGenre->color);
    }

    public function test_if_delete_is_successfull(): void
    {
        $lastGenre = Genre::all()->last();

        $lastGenre->delete();

        $this->assertModelMissing($lastGenre);
        $this->assertDatabaseCount('genres', 9);
    }
}
