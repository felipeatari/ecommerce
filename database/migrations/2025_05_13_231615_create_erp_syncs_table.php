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
        Schema::create('erp_syncs', function (Blueprint $table) {
            $table->id();
            $table->string('service');
            $table->morphs('syncable');
            $table->enum('status', ['processing', 'sucess', 'error'])->default('processing');
            $table->json('response')->nullable();
            $table->string('sync_id')->nullable();
            $table->enum('type', ['category', 'brand', 'product', 'variation', 'sku', 'order'])->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();

            $table->index('service');
            $table->index('status');
            $table->index('started_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('erp_syncs');
    }
};
