<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlowController extends Controller {

    public function index() {

        return $flow = DB::table('flows')->get();
    }
}
