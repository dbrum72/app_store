<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('cnpj_cpf', 14)->unique();            
            $table->string('celphone', 11)->nullable();
            $table->boolean('whatsapp')->default(false);
            $table->string('email')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {

        Schema::dropIfExists('clients');
    }
};
