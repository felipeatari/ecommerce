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
            $table->string('syncable_type');
            $table->unsignedBigInteger('syncable_id');
            $table->enum('status', ['processing', 'sucess', 'error'])->default('processing');
            $table->text('error_message')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
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
