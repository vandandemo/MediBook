<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            if (!Schema::hasColumn('leaves', 'admin_remarks')) {
                $table->text('admin_remarks')->nullable()->after('reason');
            }
            if (!Schema::hasColumn('leaves', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('admin_remarks');
            }
        });
    }

    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            if (Schema::hasColumn('leaves', 'admin_remarks')) {
                $table->dropColumn('admin_remarks');
            }
            if (Schema::hasColumn('leaves', 'reviewed_at')) {
                $table->dropColumn('reviewed_at');
            }
        });
    }
};
