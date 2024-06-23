<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected $seed = true;

    protected static ?User $actingUser;

    /**
     * Nastavení uživatele pro provolávání API.
     *
     * @param User|string $user
     * @return self
     */
    protected function sanctumActingAs(User|string $user): static
    {
        if (! ($user instanceof User)) {
            $user = User::query()->where('name', '=', $user)->first();
        }

        Sanctum::actingAs($user, ['*']);

        static::$actingUser = $user;

        return $this;
    }
}
