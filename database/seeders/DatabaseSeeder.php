<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@librarian.com',
            'password' => Hash::make('secret'),
            'about' => "Administrador da plataforma Librarian",
        ]);
    }
}
