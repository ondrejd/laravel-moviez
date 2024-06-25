<?php

namespace Tests\Feature\Console\Commands;

use App\Models\User;
use Symfony\Component\Console\Command\Command;
use Tests\TestCase;

class CreatePersonalAccessTokenTest extends TestCase
{
    public function test_command_expects_success(): void
    {
        $users = User::all()->pluck('name')->toArray();

        if (count($users) === 0) {
            $this->markTestSkipped('No users available - test can not be executed.');
        }

        $this
            ->artisan('app:create-personal-access-token')
            ->expectsChoice('Select user', $users[0], $users)
            ->expectsQuestion('Enter token name', 'Default token')
            ->expectsQuestion('Enter expires at', null)
            ->expectsOutputToContain('New personal access token:')
            ->assertExitCode(Command::SUCCESS);
    }

    public function test_command_expects_failure_user_not_found(): void
    {
        $users = User::all()->pluck('name')->toArray();

        if (count($users) === 0) {
            $this->markTestSkipped('No users available - test can not be executed.');
        }

        $this
            ->artisan('app:create-personal-access-token')
            ->expectsChoice('Select user', 'No user at all', $users)
            ->expectsOutput('User not found')
            ->assertExitCode(Command::FAILURE);
    }
}
