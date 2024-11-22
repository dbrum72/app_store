<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model {

    protected $fillable = [
        'user_id',
        'client_id',
        'order_progress_id'
    ];

    function user(): BelongsTo {

        return $this->belongsTo('App\Models\User');
    }

    function products(): BelongsToMany {

        return $this->belongsToMany('App\Models\Product', 'order_products')->withPivot('id','quantity','valor');
    }

    function progress(): BelongsTo {

        return $this->belongsTo('App\Models\OrderProgress');
    }
}
