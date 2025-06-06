<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovementReason extends Model {

    protected $table = 'movement_reasons';

    protected $fillable = ['movement, reason']; 

    public $timestamps = false;
}
