<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('tytul');
            $table->text('opis');
            $table->integer('czas_trwania');
            $table->integer('wiek_ograniczenie')->default(0);
            $table->string('gatunek');
            $table->string('plakat')->nullable();
            $table->boolean('aktywny')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
