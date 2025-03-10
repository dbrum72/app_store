<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    
    public function run(): void {
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(OrderProcessSeeder::class);
        $this->call(FlowsSeeder::class);
        $this->call(FlowsSeeder::class);
        $this->call(FlowTypeSeeder::class);
    }
}
