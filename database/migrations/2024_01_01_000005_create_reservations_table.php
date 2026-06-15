<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seance_id')->constrained('seances')->onDelete('cascade');
            $table->foreignId('parking_spot_id')->nullable()->constrained('parking_spots')->onDelete('set null');
            $table->dateTime('data_rezerwacji');
            $table->enum('rodzaj_pojazdu', ['osobowy', 'suv', 'van', 'motocykl'])->default('osobowy');
            $table->enum('status', ['oczekujaca', 'potwierdzona', 'zrealizowana', 'anulowana'])->default('oczekujaca');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
