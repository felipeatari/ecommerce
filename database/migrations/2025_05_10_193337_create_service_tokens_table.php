<?php

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
        Schema::create('service_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('service');
            $table->text('access_token');
            $table->text('refresh_token')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->unique('service');
        });

        DB::statement('ALTER TABLE service_tokens AUTO_INCREMENT = 1000;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_tokens');
    }
};
