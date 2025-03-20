<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['insurance_claim_id']);
            
            // Change the column type to string
            $table->string('insurance_claim_id', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Change back to unsigned bigint for foreign key
            $table->unsignedBigInteger('insurance_claim_id')->nullable()->change();
            
            // Add back the foreign key constraint
            $table->foreign('insurance_claim_id')->references('id')->on('insurance_claims')->onDelete('set null');
        });
    }
};