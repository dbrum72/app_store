<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void 
    {
        Schema::create('stock_operations', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20);
        });
    }

    public function down(): void {

        Schema::dropIfExists('stock_operations');
    }
};
