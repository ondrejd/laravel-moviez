<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Factories\Factory;
use Xylis\FakerCinema\Provider\Movie as MovieFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movie::class;

    /**
     * @var User[]|null
     */
    protected static $users;

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this
            ->afterCreating(function (Movie $movie) {
                Genre::all()
                    ->random(random_int(1, 3))
                    ->each(fn (Genre $genre) => $movie->genres()->attach($genre->id));
            });
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        $faker = Container::getInstance()->make(Generator::class);
        
        $faker->addProvider(new MovieFaker($faker));

        return $faker;
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'name' => $this->faker->movie(),
            'description' => $this->faker->paragraph(),
            'csfd' => null,
            'imdb' => null,
        ];
    }

    /**
     * @return static
     */
    public function withRandomUser(): static
    {
        if (is_null(static::$users)) {
            static::$users = User::all();
        }

        return $this->state(fn (array $attributes) => [
            'user_id' => static::$users->random(),
        ]);
    }

    /**
     * @return static
     */
    public function withUser(User $user): static
    {

        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
        ]);
    }
}
