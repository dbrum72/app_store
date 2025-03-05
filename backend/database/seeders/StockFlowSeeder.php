<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StockFlow;

class StockFlowSeeder extends Seeder {

    public function run(): void {
        StockFlow::create(['type' => 'Compra']);
        StockFlow::create(['type' => 'Venda']);
        StockFlow::create(['type' => 'Devolução']);
        StockFlow::create(['type' => 'Vencido']);
        StockFlow::create(['type' => 'Brinde']);
    }  
}
