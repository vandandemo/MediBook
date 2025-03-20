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
        if (!Schema::hasTable('prescription_medicines')) {
            Schema::create('prescription_medicines', function (Blueprint $table) {
                $table->id();
                $table->foreignId('prescription_id')->constrained()->onDelete('cascade');
                $table->foreignId('medicine_id')->constrained()->onDelete('cascade');
                $table->string('dosage');
                $table->string('duration');
                $table->text('instructions');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_medicines');
    }
}; 