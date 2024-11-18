<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {

        Schema::create('categories', function (Blueprint $table) {            
            $table->id();            
            $table->string('name', 25);
            $table->string('tree', 255);
            $table->foreignId('parent_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {

        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('categories');

        Schema::enableForeignKeyConstraints();
    }
};
