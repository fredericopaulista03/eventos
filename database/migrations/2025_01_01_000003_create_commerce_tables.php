<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('price')->default(0); // In cents
            $table->integer('stock')->default(0);
            $table->integer('max_per_order')->default(5);
            $table->dateTime('sales_start')->nullable();
            $table->dateTime('sales_end')->nullable();
            $table->timestamps();
        });

        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade'); // Null = global
            $table->string('code')->unique();
            $table->enum('type', ['percent', 'fixed']);
            $table->integer('value'); // Percent or amount in cents
            $table->integer('usage_limit')->nullable();
            $table->integer('usages')->default(0);
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Buyer
            $table->string('order_number')->unique();
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled', 'refunded'])->default('pending');
            $table->integer('total_amount'); // Final total in cents
            $table->integer('discount_amount')->default(0);
            $table->string('currency')->default('BRL');
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ticket_id')->constrained();
            $table->string('ticket_name'); // Snapshot
            $table->integer('quantity');
            $table->integer('unit_price'); // Snapshot
            $table->integer('subtotal');
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('provider'); // stripe, paypal, manual
            $table->string('provider_id')->nullable(); // Transaction ID
            $table->enum('status', ['pending', 'approved', 'declined', 'failed'])->default('pending');
            $table->integer('amount');
            $table->json('payload')->nullable(); // Webhook data
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('tickets');
    }
};
