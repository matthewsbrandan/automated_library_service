<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('transfers', function (Blueprint $table) {
            $table->string('rf_id');
        });

        Schema::table('book_stocks', function (Blueprint $table) {
            $table->foreignId('transfer_id')->nullable();
        });
    }

    public function down(): void { }
};
