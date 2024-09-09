<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('settings', function (Blueprint $table) {
      $table->id();
      $table->string('info')->nullable()->default('');
      $table->string('test_url')->nullable()->default('');
      $table->boolean('allow_insecure')->default(false);
      $table->boolean('enable_mux')->default(false);
      $table->boolean('enable_fragment')->default(false);
      $table->boolean('prefer_ipv6')->default(false);
      $table->string('custom_menu_title')->nullable()->default("");
      $table->string('custom_menu_link')->nullable()->default("");
      $table->string('version_link')->nullable()->default("");
      $table->string('version')->nullable()->default("1.0.0");
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('settings');
  }
};
