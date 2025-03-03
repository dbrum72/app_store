<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockOperation extends Model {

    protected $table = 'stock_operations';

    protected $fillable = ['type']; 

    public $timestamps = false;
}
