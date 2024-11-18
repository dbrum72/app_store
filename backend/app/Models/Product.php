<?php

namespace App\Models;

use App\Models\ProductFile;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;



class Product extends Model {

    protected $fillable = [
        'category_id',
        'barcode',
        'name',
        'description',
        'price',
        'ativo'
    ];

    public function pedidos(): BelongsToMany {

        return $this->belongsToMany('App\Models\Pedido', 'order_products');
    }

    public function category(): BelongsTo {

        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function image(): HasOne {
        return $this->hasOne('App\Models\ProductFile', 'product_id')->oldest();
    }

    public function files(): HasMany {

        return $this->hasMany('App\Models\ProductFile', 'product_id');
    }

    public function entries(): HasMany {

        return $this->hasMany('App\Models\Stock', 'product_id');
    }

    protected static function boot() {

        parent::boot();
    
        static::deleting(function($product) {

            $storeToDeletes = ProductFile::where('product_id', $product->id)->get();
            
            foreach($storeToDeletes as $storeToDelete) {                
                Storage::disk('public')->delete('files/'.$storeToDelete->storaged);
            }            
        });
    }
}
