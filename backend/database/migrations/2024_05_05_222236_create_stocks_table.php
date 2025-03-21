<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {

        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flow_id');
            $table->foreignId('flow_type_id');
            $table->foreignId('order_id')->nullable();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->float('price', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void {

        Schema::dropIfExists('stocks');
    }
};