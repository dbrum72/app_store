<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlowType extends Model {

    protected $table = 'flow_types';

    protected $fillable = [
        'flow_id',
        'type'
    ];

    public $timestamps = false;
}
