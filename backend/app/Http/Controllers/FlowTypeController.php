<?php

namespace App\Http\Controllers;

use App\Models\FlowType;
use Illuminate\Support\Facades\DB;

class FlowTypeController extends Controller {

    public function __construct(FlowType $flowType) {

        $this->flowType = $flowType;
    }

    /********************************************************************************************************/

    public function index($flow) {

        return $this->flowType = DB::table('flow_types')->where('flow_id', $flow)->get();
    }
}
