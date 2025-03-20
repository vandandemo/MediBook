<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('specializations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create a default specialization
        DB::table('specializations')->insert([
            'name' => 'General Medicine',
            'description' => 'General Medical Practice',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Add foreign key constraint to doctors table
        Schema::table('doctors', function (Blueprint $table) {
            $table->foreign('specialization_id')->references('id')->on('specializations');
        });

        // Get the default specialization ID and update existing doctors
        $defaultSpecId = DB::table('specializations')->where('name', 'General Medicine')->value('id');
        DB::table('doctors')->update(['specialization_id' => $defaultSpecId]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['specialization_id']);
        });
        Schema::dropIfExists('specializations');
    }
};