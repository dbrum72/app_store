<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Flow extends Model {

    protected $table = 'stock_flows';

    protected $fillable = ['type']; 

    public $timestamps = false;
}
