<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Genre>
 */
class GenreFactory extends Factory
{
    public const DEFAULT_GENRES = [
        'Akční',
        'Animovaný',
        'Dětský',
        'Dobrodružný',
        'Drama',
        'Fantasy',
        'Historický',
        'Horor',
        'Krimi',
        'Romantický',
        'Sci-fi',
        'Válečný',
        'Umělecký',
    ];

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Genre::class;

    /**
     * @var User[]|null
     */
    protected static $users;

    /**
     * @var array
     */
    protected static $usedGenres = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genres = array_diff(self::DEFAULT_GENRES, self::$usedGenres);

        static::$usedGenres[] = $selectedGenre = $this->faker->randomElement($genres);

        return [
            'name' => $selectedGenre,
            'color' => $this->faker->unique(true)->safeHexColor(),
        ];
    }
}
