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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->string('type', 50); // Changed from enum to string, e.g., 'in_returned', 'out_approved', 'initial_stock', 'adjustment_damaged'
            $table->integer('quantity_changed'); // Can be positive (in) or negative (out)
            $table->text('reason')->nullable(); // Reason for adjustment or movement
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // User who performed/authorized
            $table->timestamp('movement_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
