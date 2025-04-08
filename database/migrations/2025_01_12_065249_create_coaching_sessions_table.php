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
        Schema::create('coaching_sessions', function (Blueprint $table) {
            $table->id();

            // $table->integer('duration');
            $table->enum('type', ['hourly', 'monthly']);

            $table->timestamp('start_date');
            $table->timestamp('end_date');

            $table->foreignId('instructor_id')
                ->references('id')
                ->on('instructors');

            $table->foreignId('client_id')
                ->references('id')
                ->on('clients');

            // $table->string('location');

            $table->string('notes')->default('');
            $table->boolean('disabled')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coaching_sessions');
    }
};
