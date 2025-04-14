<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MovementReason;

class MovementReasonSeeder extends Seeder {
    
    public function run(): void {
        MovementReason::create(['movement' => 'in', 'reason' => 'Aquisição']);
        MovementReason::create(['movement' => 'out', 'reason' => 'Venda']);
        MovementReason::create(['movement' => 'in', 'reason' => 'Devolução']);
        MovementReason::create(['movement' => 'out', 'reason' => 'Vencido']);
        MovementReason::create(['movement' => 'out', 'reason' => 'Brinde']);
        MovementReason::create(['movement' => 'in', 'reason' => 'Ajuste manual - entrada']);
        MovementReason::create(['movement' => 'out', 'reason' => 'Ajuste manual - saída']);
    }
}
