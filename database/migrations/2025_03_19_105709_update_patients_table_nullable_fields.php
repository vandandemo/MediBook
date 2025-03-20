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
        Schema::table('patients', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('patients', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('patients', 'address')) {
                $table->text('address')->nullable();
            }
            if (!Schema::hasColumn('patients', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable();
            }
            if (!Schema::hasColumn('patients', 'blood_group')) {
                $table->string('blood_group')->nullable();
            }
            if (!Schema::hasColumn('patients', 'gender')) {
                $table->string('gender')->nullable();
            }
            if (!Schema::hasColumn('patients', 'active')) {
                $table->boolean('active')->default(true);
            }
            
            // Ensure social auth fields are nullable
            if (!Schema::hasColumn('patients', 'provider')) {
                $table->string('provider')->nullable();
            }
            if (!Schema::hasColumn('patients', 'provider_id')) {
                $table->string('provider_id')->nullable();
            }
            if (!Schema::hasColumn('patients', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable();
            }
            if (!Schema::hasColumn('patients', 'remember_token')) {
                $table->rememberToken();
            }
        });

        // Now make existing columns nullable if they exist
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'phone')) {
                $table->string('phone')->nullable()->change();
            }
            if (Schema::hasColumn('patients', 'address')) {
                $table->text('address')->nullable()->change();
            }
            if (Schema::hasColumn('patients', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->change();
            }
            if (Schema::hasColumn('patients', 'blood_group')) {
                $table->string('blood_group')->nullable()->change();
            }
            if (Schema::hasColumn('patients', 'gender')) {
                $table->string('gender')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Make fields required again
            $table->string('phone')->nullable(false)->change();
            $table->text('address')->nullable(false)->change();
            $table->date('date_of_birth')->nullable(false)->change();
            $table->string('blood_group')->nullable(false)->change();
            $table->string('gender')->nullable(false)->change();
        });
    }
};
