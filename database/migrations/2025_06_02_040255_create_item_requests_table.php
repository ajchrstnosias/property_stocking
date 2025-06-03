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
        Schema::create('item_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User who requested
            $table->unsignedInteger('requested_quantity');
            $table->string('status')->default('pending'); // pending, approved, denied, completed
            $table->text('remarks')->nullable(); // Optional remarks from requester or admin
            $table->foreignId('processed_by_id')->nullable()->constrained('users')->onDelete('set null'); // Admin who processed
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_requests');
    }
};
