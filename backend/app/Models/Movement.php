<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movement extends Model {

    protected $fillable = [        
        'order_id',
        'product_id',
        'movement',
        'movement_reason_id',
        'quantity'
    ];

    public function product(): BelongsTo {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function movement_reason(): BelongsTo {
            return $this->belongsTo('App\Models\MovementReason', 'movement_reason_id')
                ->selectRaw('id,movement,reason');
        }
}