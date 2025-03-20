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
        if (!Schema::hasTable('prescriptions')) {
            Schema::create('prescriptions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
                $table->foreignId('patient_id')->constrained()->onDelete('cascade');
                $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
                $table->text('diagnosis');
                $table->text('medications');
                $table->text('instructions');
                $table->text('notes')->nullable();
                $table->string('status');
                $table->date('valid_until');
                $table->boolean('is_sent_to_pharmacy')->default(false);
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
        Schema::dropIfExists('prescriptions');
    }
}; 