<?php

use App\User;
use Illuminate\Database\Seeder;

class PasswordSecret extends Seeder
{
    public function run()
    {
        User::query()
            ->update([
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',  // secret
            ]);
    }
}
