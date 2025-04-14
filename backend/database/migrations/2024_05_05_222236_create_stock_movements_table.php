<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->enum('movement', ['in', 'out']);
            $table->foreignId('movement_reason_id');                        
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down(): void {

        Schema::dropIfExists('stock_movements');
    }
};