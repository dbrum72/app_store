<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model {

    protected $fillable = [
        'user_id',
        'client_id',
        'order_progress_id'
    ];

    function user(): BelongsTo {

        return $this->belongsTo('App\Models\User');
    }

    function items(): HasMany {

        return $this->hasMany('App\Models\OrderItem');
    }

    function progress(): BelongsTo {

        return $this->belongsTo('App\Models\OrderProgress');
    }
}
