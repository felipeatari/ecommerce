<?php

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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
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
            $table->softDeletes('removed_at');
        });

        DB::statement('ALTER TABLE brands AUTO_INCREMENT = 1000;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
