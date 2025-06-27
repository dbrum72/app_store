<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    
    public function run(): void {

        User::create([
            'name' => 'Dario Brum',
            'email' => 'dbrum72@gmail.com',
            'password' => Hash::make('password'),
            'cnpj_cpf' => '66869650063'
        ]);
    }
}