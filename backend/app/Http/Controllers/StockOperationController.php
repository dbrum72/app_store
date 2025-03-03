<?php

namespace App\Http\Controllers;
use App\Models\StockOperation;

use Illuminate\Http\Request;

class StockOperationController extends Controller {

    public function __construct(StockOperation $stockOperation) {

        $this->stockOperation = $stockOperation;
    }

    public function index() {
        
        return $this->stockOperation->get();
    }
}
