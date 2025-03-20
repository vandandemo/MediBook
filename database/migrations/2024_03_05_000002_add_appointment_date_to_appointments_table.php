<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->date('appointment_date')->after('scheduled_time')->nullable();
        });
        
        // Update existing records after column is created
        DB::statement('UPDATE appointments SET appointment_date = DATE(scheduled_time)');
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('appointment_date');
        });
    }
};