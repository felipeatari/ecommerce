<?php

use App\Models\Product;
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
        Schema::create('skus', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
                ->constrained();
            $table->foreignIdFor(Variation::class, 'variation_id_1')
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
                ->constrained('variations');
            $table->foreignIdFor(Variation::class, 'variation_id_2')
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
                ->constrained('variations');
            $table->integer('stock')->nullable();
            $table->integer('price')->nullable();
            $table->integer('cost_price')->nullable();
            $table->integer('discount_price')->nullable();
            $table->boolean('active')->default(true);
            $table->float('weight', 3)->nullable();
            $table->float('width', 2)->nullable();
            $table->float('height', 2)->nullable();
            $table->float('length', 2)->nullable();
            $table->string('cover')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE skus AUTO_INCREMENT = 1000;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skus');
    }
};
