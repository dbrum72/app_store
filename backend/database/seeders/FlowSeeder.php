<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlowSeeder extends Seeder {
    
    public function run(): void {

        DB::table('flows')->insert([ 'flow' => 'Entrada']);
        DB::table('flows')->insert([ 'flow' => 'Saída']);
    }
}
