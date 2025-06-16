<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model {

    use SoftDeletes;

    protected $table = 'users_addresses';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'street',        
        'complement',
        'district',
        'city',
        'zipcode',
        'main',
        'user_id'     
    ];

    public function user(): BelongsTo {

        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
