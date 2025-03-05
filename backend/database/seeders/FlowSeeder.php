<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Flow;

class FlowSeeder extends Seeder {
    
    public function run(): void {
        Flow::create(['flow' => 'Entrada']);
        Flow::create(['flow' => 'Saída']);
    }
}
