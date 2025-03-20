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
        if (!Schema::hasTable('medicines')) {
            Schema::create('medicines', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('generic_name')->nullable();
                $table->string('brand')->nullable();
                $table->string('category');
                $table->text('description')->nullable();
                $table->decimal('unit_price', 10, 2);
                $table->integer('stock_quantity')->default(0);
                $table->string('unit')->nullable(); // e.g., tablets, ml, etc.
                $table->boolean('requires_prescription')->default(true);
                $table->boolean('active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
}; 