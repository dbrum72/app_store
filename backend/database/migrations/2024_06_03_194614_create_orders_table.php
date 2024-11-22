<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('order_progress_id')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void {

        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('orders');

        Schema::enableForeignKeyConstraints();
    }
};