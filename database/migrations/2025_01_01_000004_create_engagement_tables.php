<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained('order_items')->onDelete('cascade');
            $table->timestamp('scanned_at');
            $table->string('device_id')->nullable();
            $table->string('scanned_by_user_id')->nullable(); // Staff ID
            $table->timestamps();
        });

        Schema::create('affiliates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('code')->unique();
            $table->float('commission_rate')->default(0.05); // 5%
            $table->integer('total_visits')->default(0);
            $table->integer('total_conversions')->default(0);
            $table->timestamps();
        });

        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('subject');
            $table->text('message');
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('action'); // e.g., 'event.updated'
            $table->string('target_type')->nullable(); // e.g., 'Event'
            $table->bigInteger('target_id')->nullable();
            $table->json('meta')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });

        Schema::create('event_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->date('viewed_on');
            $table->integer('count')->default(1);
            $table->unique(['event_id', 'viewed_on']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_views');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('support_tickets');
        Schema::dropIfExists('affiliates');
        Schema::dropIfExists('checkins');
    }
};
