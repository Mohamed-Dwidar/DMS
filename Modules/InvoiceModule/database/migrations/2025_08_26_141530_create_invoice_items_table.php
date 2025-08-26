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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_id')->default(0);
            $table->string('item_name');
            $table->text('item_desc')->nullable();
            $table->integer('item_qty')->default(1);            
            $table->decimal('item_unit_amount', 10, 2)->default(0);
            $table->decimal('item_discount_per', 5, 2)->default(0);
            $table->decimal('item_discount', 10, 2)->default(0);
            $table->decimal('item_total_amount', 10, 2)->default(0);
            $table->string('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
