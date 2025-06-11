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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('trx')->unique();
            $table->foreignUuid('column_id')->constrained();
            $table->foreignUuid('product_id')->nullable()->constrained();
            $table->foreignUuid('contact_id')->nullable()->constrained();
            $table->foreignUuid('sector_id')->nullable()->constrained();
            $table->double('current_price')->nullable();
            $table->integer('qty')->nullable();
            $table->double('grand_total')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
