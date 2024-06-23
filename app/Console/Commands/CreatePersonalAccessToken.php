<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreatePersonalAccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-personal-access-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create personal access token for selected user';

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle(): int
    {
        $userName = $this->choice(
            'Select user',
            User::all(['id', 'name'])->map(fn (User $user) => $user->name)->toArray()
        );
        $user = User::query()->where('name', $userName)->first();

        if ($user === null) {
            $this->error('User not found');

            return self::FAILURE;
        }

        $tokenName = $this->ask('Enter token name', 'Default token');
        $expiresAt = $this->ask('Enter expires at', null);

        if ($expiresAt !== null) {
            $expiresAt = new \DateTime($expiresAt);
        }

        $newAccessToken = $user->createToken($tokenName, ['*'], $expiresAt);

        $this->info(sprintf('New personal access token: %s', $newAccessToken->plainTextToken));

        return self::SUCCESS;
    }
}
