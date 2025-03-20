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
        if (!Schema::hasColumn('invoices', 'invoice_number')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->string('invoice_number')->after('id')->nullable();
            });
        }

        // Update existing records with unique invoice numbers
        $invoices = DB::table('invoices')->whereNull('invoice_number')->orWhere('invoice_number', '')->get();
        foreach ($invoices as $invoice) {
            DB::table('invoices')
                ->where('id', $invoice->id)
                ->update(['invoice_number' => 'INV-' . str_pad($invoice->id, 6, '0', STR_PAD_LEFT)]);
        }

        Schema::table('invoices', function (Blueprint $table) {
            $table->unique('invoice_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('invoice_number');
        });
    }
};
