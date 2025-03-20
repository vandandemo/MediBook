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
            // Remove user_id if it exists
            if (Schema::hasColumn('patients', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }

            // Add social auth columns
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'provider',
                'provider_id',
                'email_verified_at',
                'remember_token'
            ]);

            // Add back user_id if needed
            $table->foreignId('user_id')->nullable()->constrained();
        });
    }
};
