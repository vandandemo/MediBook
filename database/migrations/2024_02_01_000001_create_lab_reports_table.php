<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('test_type', ['blood', 'urine', 'xray', 'mri']);
            $table->date('test_date');
            $table->text('results');
            $table->text('comments')->nullable();
            $table->string('report_number')->unique();
            $table->text('findings')->nullable();
            $table->text('conclusion')->nullable();
            $table->text('recommendations')->nullable();
            $table->string('status')->default('pending');
            $table->string('file_path')->nullable();
            $table->timestamp('report_date');
            $table->boolean('is_critical')->default(false);
            $table->boolean('is_viewed_by_doctor')->default(false);
            $table->boolean('is_viewed_by_patient')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_reports');
    }
};