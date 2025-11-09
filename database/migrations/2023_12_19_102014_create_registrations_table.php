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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('id_number')->nullable()->unique();
            $table->string('department')->nullable();
            $table->string('gender')->nullable();
            $table->string('count');
            $table->string('type')->nullable();
            $table->string('lucky_number');
            $table->boolean('qr_status')->default(false);
            $table->boolean('is_check_out')->default(false);
            $table->boolean('status')->default(false);
            $table->boolean('is_email_sent')->default(false);
            $table->string('qr_code_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
