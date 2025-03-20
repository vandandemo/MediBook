<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lab_reports', function (Blueprint $table) {
            // Add the report_number column if it doesn't exist
            if (!Schema::hasColumn('lab_reports', 'report_number')) {
                $table->string('report_number')->unique();
            }
        });

        // Create the trigger after ensuring the column exists
        DB::unprepared('DROP TRIGGER IF EXISTS tr_lab_reports_before_insert');
        DB::unprepared('
            CREATE TRIGGER tr_lab_reports_before_insert
            BEFORE INSERT ON lab_reports
            FOR EACH ROW
            BEGIN
                DECLARE next_val INT;
                SET next_val = (SELECT IFNULL(MAX(CAST(SUBSTRING(report_number, 4) AS UNSIGNED)), 0) + 1 FROM lab_reports);
                SET NEW.report_number = CONCAT("LAB", LPAD(next_val, 6, "0"));
            END
        ');
    }

    public function down(): void
    {
        Schema::table('lab_reports', function (Blueprint $table) {
            $table->dropColumn('report_number');
            $table->string('report_number')->unique();
        });
    }
};