<?php

namespace Database\Seeders;

use App\Models\OrderProgress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderProgressSeeder extends Seeder {

    public function run(): void {
        
        OrderProgress::create(['name' => 'Processamento']);
        OrderProgress::create(['name' => 'Faturamento']);
        OrderProgress::create(['name' => 'Separação/Preparação do envio']);
        OrderProgress::create(['name' => 'Expedição (Envio) / Retirada na Loja']);               
        OrderProgress::create(['name' => 'Transporte']);
        OrderProgress::create(['name' => 'Entregue']);
    }
}
