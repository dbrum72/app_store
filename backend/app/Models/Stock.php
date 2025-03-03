<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model {

    use HasFactory;

    protected $fillable = [
        'type',
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

   public function product(): BelongsTo {

       return $this->belongsTo('App\Models\Product', 'product_id')
        ->selectRaw('id,name');
   }
}
