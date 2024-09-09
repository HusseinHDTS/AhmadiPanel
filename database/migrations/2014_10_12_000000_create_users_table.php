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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('internet_type');
            $table->string('username')->default('');
            $table->integer('active_sessions')->default(0);
            $table->integer('max_active_session')->default(0);
            $table->datetime('start_sub_date')->useCurrent();
            $table->integer('sub_days')->default(30);
            $table->integer('max_volume')->default(300);
            $table->integer('current_volume')->default(0);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
