<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'cnpj_cpf',        
        'celphone',
        'whatsapp',
        'email',
    ];

    public function addresses(): HasMany {

        return $this->hasMany('App\Models\ClientAddress', 'client_id');
    }
}
