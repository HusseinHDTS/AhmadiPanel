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
    Schema::create('configs', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->integer('order');
      $table->string('internet_type');
      $table->string('active')->default("true");
      $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
      $table->text('config'); // Use 'text' if storing large strings or JSON as strings
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('configs');
  }
};
