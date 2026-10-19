<?php

declare(strict_types=1);

use App\Enums\OrderStatus;
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
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->unsignedInteger('order_number')->unique();
            $table->string('status')->default(OrderStatus::Pending->value);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('delivery', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('currency')->nullable();
            $table->foreignUuid('shipping_address_id')->constrained('addresses');
            $table->foreignUuid('billing_address_id')->constrained('addresses');
            $table->string('session_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
