<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('parking_spots', function (Blueprint $table) {
            $table->id();
            $table->string('numer_miejsca');
            $table->enum('typ_pojazdu', ['osobowy', 'suv', 'van', 'motocykl'])->default('osobowy');
            $table->enum('status', ['wolne', 'zarezerwowane', 'zajete'])->default('wolne');
            $table->integer('rzad')->nullable();
            $table->integer('kolumna')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parking_spots');
    }
};
