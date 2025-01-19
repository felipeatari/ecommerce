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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
                ->constrained();
            $table->string('zip_code');
            $table->string('city');
            $table->string('state');
            $table->string('neighborhood');
            $table->string('address');
            $table->integer('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('country')->default('Brasil');
            $table->string('country_code')->default('BR');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE user_addresses AUTO_INCREMENT = 1000;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
