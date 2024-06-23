<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Genre::factory(10)->create();

        User::factory(3)
            ->create()
            ->each(function (User $user) {
                Movie::factory(random_int(15, 25))->withUser($user)->create();
            });
    }
}
