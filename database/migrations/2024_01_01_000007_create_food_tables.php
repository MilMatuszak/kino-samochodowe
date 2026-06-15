<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('food_products', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa');
            $table->decimal('cena', 8, 2);
            $table->boolean('dostepnosc')->default(true);
            $table->string('kategoria')->default('przekąski');
            $table->string('zdjecie')->nullable();
            $table->timestamps();
        });

        Schema::create('food_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reservation_id')->nullable()->constrained('reservations')->onDelete('set null');
            $table->dateTime('czas_zlozenia');
            $table->enum('platnosc', ['online', 'przy_odbiorze'])->default('przy_odbiorze');
            $table->decimal('suma', 8, 2)->default(0);
            $table->enum('status', ['nowe', 'przyjete', 'w_realizacji', 'dostarczone', 'anulowane'])->default('nowe');
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_order_id')->constrained('food_orders')->onDelete('cascade');
            $table->foreignId('food_product_id')->constrained('food_products')->onDelete('cascade');
            $table->integer('ilosc')->default(1);
            $table->decimal('cena_jednostkowa', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('food_orders');
        Schema::dropIfExists('food_products');
    }
};
