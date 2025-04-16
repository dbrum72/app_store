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
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function movement_reason(): HasMany {

            return $this->hasMany('App\Models\MovementReason', 'id')
            ->selectRaw('id,movement,reason');
        }
}