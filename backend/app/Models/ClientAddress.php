<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientAddress extends Model {

    use SoftDeletes;

    protected $table = 'clients_addresses';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'street',        
        'complement',
        'district',
        'city',
        'zipcode',
        'main',
        'client_id'     
    ];

    public function client(): BelongsTo {

        return $this->belongsTo('App\Models\Client', 'client_id');
    }
}
