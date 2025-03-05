<?php

namespace App\Http\Controllers;
use App\Models\Flow;

use Illuminate\Http\Request;

class FlowController extends Controller {

    public function __construct(Flow $flow) {

        $this->flow = $flow;
    }

    public function index() {
        
        return $this->flow->get();
    }
}
