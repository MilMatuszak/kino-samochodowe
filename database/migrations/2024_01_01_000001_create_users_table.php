<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('imie_nazwisko');
            $table->string('email')->unique();
            $table->string('haslo');
            $table->enum('rola', ['klient', 'pracownik', 'kierownik', 'partner', 'administrator'])->default('klient');
            $table->string('telefon')->nullable();
            $table->boolean('aktywny')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
