<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderProcessSeeder extends Seeder {

    public function run(): void {
        
        DB::table('order_processes')->insert(['process' => 'Processamento']);
        DB::table('order_processes')->insert(['process' => 'Faturamento']);
        DB::table('order_processes')->insert(['process' => 'Separação/Preparação do envio']);
        DB::table('order_processes')->insert(['process' => 'Expedição (Envio) / Retirada na Loja']);               
        DB::table('order_processes')->insert(['process' => 'Transporte']);
        DB::table('order_processes')->insert(['process' => 'Entregue']);
    }
}