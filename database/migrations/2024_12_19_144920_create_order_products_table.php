<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\Sku;
use App\Models\Variation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
                ->constrained();
            $table->foreignIdFor(Product::class)
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
                ->constrained();
            $table->foreignIdFor(Sku::class)
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
                ->constrained();
            $table->string('name');
            $table->integer('price_un');
            $table->integer('price_total');
            $table->integer('quantity');
            $table->string('color');
            $table->string('size');
            $table->string('image');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes('removed_at');
        });

        DB::statement('ALTER TABLE order_products AUTO_INCREMENT = 1000;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
