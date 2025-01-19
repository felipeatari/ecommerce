<?php

use App\Models\Coupon;
use App\Models\OrderStatus;
use App\Models\User;
use App\Models\UserAddress;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
                ->constrained();
            $table->integer('status');
            $table->integer('subtotal');
            $table->integer('discount');
            $table->integer('total');
            $table->string('payment_gateway');
            $table->string('payment_type');
            $table->integer('payment_installment');
            $table->string('shipping_name');
            $table->integer('shipping_price');
            $table->integer('shipping_delivery_time');
            $table->string('delivery_city');
            $table->string('delivery_state');
            $table->string('delivery_neighborhood');
            $table->string('delivery_address');
            $table->integer('delivery_number')->nullable()->default(0);
            $table->string('delivery_complement')->nullable();
            $table->string('delivery_country')->default('Brasil');
            $table->string('delivery_country_code')->default('BR');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE user_addresses AUTO_INCREMENT = 1000;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
