<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class GenerateApiTokenForSpotifyUser extends Command
{
    protected $signature = 'api:auth';
    protected $description = 'Generates an api token for first user in database that is connected to spotify.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        /** @var User $user */
        $user = User::where('spotify_id', '!=', null)->first();
        if (!$user) {
            $this->warn("No spotify user found.");
            return;
        }
        $token = $user->createToken(config('auth.api_token_name'));
        $this->info("Created access token for user {$user->name} ({$user->id})");
        $this->info($token->accessToken);
    }
}
