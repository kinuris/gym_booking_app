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
        Schema::create('progress_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('coaching_session_id')
                ->references('id')
                ->on('coaching_sessions')
                ->cascadeOnDelete();

            $table->foreignId('client_id')
                ->references('id')
                ->on('clients')
                ->cascadeOnDelete();

            $table->string('weight')
                ->nullable();

            $table->time('start_time');
            $table->time('end_time');
            $table->date('date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_records');
    }
};
