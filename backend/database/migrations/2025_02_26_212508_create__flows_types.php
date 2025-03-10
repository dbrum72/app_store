<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {
        Schema::create('flow_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flow_id');
            $table->string('type', 20);
        });
    }

    public function down(): void {

        Schema::dropIfExists('flow_types');
    }
};
