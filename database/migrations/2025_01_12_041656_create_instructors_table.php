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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email')->unique();

            $table->enum('gender', ['male', 'female']);

            $table->decimal('hourly_rate', 8, 2);
            $table->decimal('monthly_rate', 8, 2);
            $table->string('profile_image')->nullable();
            $table->date('birthdate');
            $table->string('password');

            $table->string('phone_number');

            $table->text('bio')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};
