<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('leaves', function (Blueprint $table) {
            if (!Schema::hasColumn('leaves', 'staff_id')) {
                $table->unsignedBigInteger('staff_id')->after('staff_type');
            }

            // Modify doctor_id column safely
            if (Schema::hasColumn('leaves', 'doctor_id')) {
                $table->foreignId('doctor_id')->nullable()->change();
            }
        });
    }

    public function down()
    {
        Schema::table('leaves', function (Blueprint $table) {
            if (Schema::hasColumn('leaves', 'staff_id')) {
                $table->dropColumn('staff_id');
            }

            if (Schema::hasColumn('leaves', 'doctor_id')) {
                $table->foreignId('doctor_id')->nullable(false)->change();
            }
        });
    }
};
