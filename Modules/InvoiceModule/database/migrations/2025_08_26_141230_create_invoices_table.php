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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('customer_id')->default(0);
            $table->string('inv_number')->unique();
            $table->date('date');
            $table->string('inv_for');
            
            $table->decimal('amount', 10, 2);
            $table->decimal('inv_discount_per', 5, 2)->default(0);
            $table->decimal('inv_discount', 10, 2)->default(0);
            $table->decimal('tax_vat_per', 5, 2);
            $table->decimal('tax_vat', 10, 2);
            $table->decimal('tax_withdrawal_per', 5, 2);
            $table->decimal('tax_withdrawal', 10, 2);
            $table->decimal('total_amount', 10, 2);

            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
