<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('barcode')->nullable();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name', 255);
            $table->text('description');
            $table->decimal('price')->default('0.00');         
            $table->boolean('active')->default('1');
            $table->timestamps();
        });
    }

    public function down(): void {

        Schema::dropIfExists('products');
    }
};
