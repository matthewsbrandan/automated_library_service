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
        Schema::table('book_stocks', function (Blueprint $table) {
            $table->enum('status', ['reserved', 'borrowed', 'available']);
            $table->unique('rf_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_stocks', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropUnique('book_stocks_rf_id_unique');
        });
    }
};
