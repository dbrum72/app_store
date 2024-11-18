<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderProgress extends Model {

    protected $table = 'orders_progress';

    protected $fillable = ['name'];

    public $timestamps = false;

    function order(): HasMany {

        return $this->hasMany('App\Models\Order', 'order_progress_id');
    }
}
