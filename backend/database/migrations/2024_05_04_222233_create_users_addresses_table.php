<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {

        Schema::create('users_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street', 255);
            $table->string('complement', 255)->nullable();
            $table->string('district', 255);
            $table->string('city', 255);
            $table->string('zipcode', 8)->nullable();
            $table->boolean('main')->default(0);
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /********************************************************************************************************/
    
    public function down(): void {

        Schema::dropIfExists('users_addresses');
    }
};
