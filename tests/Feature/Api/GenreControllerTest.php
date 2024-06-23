<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GenreControllerTest extends TestCase
{
    public function test_list_genres(): void
    {
        $this
            ->sanctumActingAs(User::all()->first())
            ->get('/api/v1/genres')
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json
                    ->has(10)
                    ->has(
                        '0',
                        fn (AssertableJson $json) => $json->hasAll(['Id', 'Name', 'Color'])
                    );
            });
    }
}
