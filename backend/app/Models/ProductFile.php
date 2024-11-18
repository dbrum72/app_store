<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ProductFile extends Model {

    protected $table = 'product_files';

    protected $fillable = [
        'name',
        'storaged',
        'product_id' 
    ];

    function product(): BelongsTo {

        return $this->belongsTo(Product::class);
    }
}