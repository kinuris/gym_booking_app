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
        Schema::create('home_client_stories', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('subtitle');

            $table->string('body');

            $table->string('image_link_1');
            $table->string('image_link_2')->nullable();

            $table->enum('status', ['disabled', 'active'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_client_stories');
    }
};
