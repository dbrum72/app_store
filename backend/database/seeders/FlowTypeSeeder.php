<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FlowType;

class FlowTypeSeeder extends Seeder {
    
    public function run(): void {
        FlowType::create(['flow_id' => '1', 'type' => 'Compra']);
        FlowType::create(['flow_id' => '2', 'type' => 'Venda']);
        FlowType::create(['flow_id' => '1', 'type' => 'Devolução']);
        FlowType::create(['flow_id' => '2', 'type' => 'Vencido']);
        FlowType::create(['flow_id' => '2', 'type' => 'Brinde']);
    }
}
