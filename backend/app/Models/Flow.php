<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flow extends Model {

    protected $table = 'flows';

    protected $fillable = ['flow'];

    public $timestamps = false;
}
