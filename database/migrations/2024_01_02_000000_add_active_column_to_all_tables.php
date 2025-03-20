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
        Schema::table('admins', function (Blueprint $table) {
            $table->boolean('active')->default(1);
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->boolean('active')->default(1);
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->boolean('active')->default(1);
        });

        Schema::table('receptionists', function (Blueprint $table) {
            $table->boolean('active')->default(1);
        });

        Schema::table('cashiers', function (Blueprint $table) {
            $table->boolean('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('active');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('active');
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('active');
        });

        Schema::table('receptionists', function (Blueprint $table) {
            $table->dropColumn('active');
        });

        Schema::table('cashiers', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
};