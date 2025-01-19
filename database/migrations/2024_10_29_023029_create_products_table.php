<?php

use App\Models\Category;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
                ->constrained();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->foreignIdFor(Category::class, 'brand')
            ->nullable()
            ->cascadeOnDelete()
            ->cascadeOnUpdate()
            ->constrained();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE products AUTO_INCREMENT = 1000;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
