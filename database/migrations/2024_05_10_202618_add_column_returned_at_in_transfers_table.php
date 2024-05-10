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
    Schema::table('transfers', function (Blueprint $table) {
      $table->timestamp('returned_at')->nullable();
      $table->enum('status', ['requested','reserved', 'borrowed', 'expired', 'returned'])->change();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('transfers', function (Blueprint $table) {
      //
    });
  }
};
