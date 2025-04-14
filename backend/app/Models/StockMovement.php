<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockMovement extends Model {

    protected $fillable = [        
        'order_id',
        'product_id',
        'movement_reason_id',
        'quantity'
    ];

   public function product(): BelongsTo {

       return $this->belongsTo('App\Models\Product', 'product_id')
        ->selectRaw('id,name');
   }

   public function movement_reason(): HasMany {

        return $this->hasMany('App\Models\MovementReason', 'movement_reason_id')
        ->selectRaw('movement,reason');
    }
}