<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'wallet_address' => '0x1234567890abcdef1234567890abcdef12345678', // Dummy Ethereum address
            'nonce' => Str::random(10), // Random 10 character string
            'auth_message' => 'Please sign this message to authenticate.', // Dummy auth message
            'name' => 'Test User',
            'email' => 'admin@blockchain.com', // Default role
            'role' => 'admin', // Default role
            'password' => Hash::make('password123'),
        ]);
    }
}
