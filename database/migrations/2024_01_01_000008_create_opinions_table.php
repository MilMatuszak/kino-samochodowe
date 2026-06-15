<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('opinions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('film_id')->constrained('films')->onDelete('cascade');
            $table->integer('ocena');
            $table->text('komentarz')->nullable();
            $table->enum('status_moderacji', ['nowa', 'oczekujaca', 'opublikowana', 'ukryta'])->default('oczekujaca');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opinions');
    }
};
