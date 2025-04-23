<?php

namespace App\Http\Controllers;

use App\Models\MovementReason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovementReasonController extends Controller {

    public function getMovementTypes() {

        if($movements = MovementReason::select('movement')->distinct()->pluck('movement')) {
            
            return $movements;
        }

        return response()->json(['errors' => ['error' => 'Não foi possível carregar tipos de movimentos de estoque']], 404);
    }

    public function getReasonByMovement($movement) {

        if($reasons = MovementReason::selectRaw('id, movement, reason')->where('movement', $movement)->get()) {
            
            return $reasons;
        }

        return response()->json(['errors' => ['error' => 'Não foi possível carregar as razões dd movimento de estoque']], 404);
    }
}
