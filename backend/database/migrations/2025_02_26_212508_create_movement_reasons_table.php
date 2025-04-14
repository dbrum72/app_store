<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {
        Schema::create('movement_reasons', function (Blueprint $table) {
            $table->id();
            $table->enum('movement', ['in', 'out']);
            $table->string('reason', 25);
        });
    }

    public function down(): void {

        Schema::dropIfExists('movement_reasons');
    }
};
