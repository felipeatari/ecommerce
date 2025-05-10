<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('value')->unique();
            $table->string('code')->unique()->nullable();
            $table->text('extra')->nullable();
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
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes('removed_at');
        });

        DB::statement('ALTER TABLE variations AUTO_INCREMENT = 1000;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variations');
    }
};
