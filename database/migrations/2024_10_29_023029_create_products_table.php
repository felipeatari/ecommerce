<?php

use App\Models\Category;
use App\Models\User;
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
            $table->foreignIdFor(User::class, 'created_by')
                ->nullable()
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
                ->constrained();
            $table->foreignIdFor(User::class, 'updated_by')
                ->nullable()
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
                ->constrained();
            $table->foreignIdFor(User::class, 'removed_by')
                ->nullable()
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
                ->constrained();
            $table->timestamps();
            $table->softDeletes();
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
