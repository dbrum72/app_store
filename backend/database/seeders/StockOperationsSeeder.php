<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StockOperation;

class StockOperationsSeeder extends Seeder {

    public function run(): void {
        StockOperation::create(['type' => 'Compra']);
        StockOperation::create(['type' => 'Venda']);
        StockOperation::create(['type' => 'Devolução']);
        StockOperation::create(['type' => 'Vencido']);
    }  
}
