<?php

namespace App\Http\Controllers;
use App\Models\StockFlow;

use Illuminate\Http\Request;

class StockFlowController extends Controller {

    public function __construct(StockFlow $stockOperation) {

        $this->stockOperation = $stockOperation;
    }

    public function index() {
        
        return $this->stockOperation->get();
    }
}
