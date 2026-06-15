<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('film_id')->constrained('films')->onDelete('cascade');
            $table->date('data');
            $table->time('godzina_rozpoczecia');
            $table->string('ekran_projekcyjny')->default('Ekran główny');
            $table->enum('status', ['zaplanowany', 'aktywny', 'w_trakcie', 'zakonczony', 'odwolany'])->default('zaplanowany');
            $table->decimal('cena_biletu', 8, 2)->default(30.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seances');
    }
};
