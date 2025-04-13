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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Event title
            $table->string('slug'); // Event title
            $table->longText('description')->nullable(); // Event details
            $table->string('location')->nullable(); // Venue
            $table->dateTime('start_time'); // Start date & time
            $table->dateTime('end_time')->nullable(); // End date & time
            $table->string('status')->default('upcoming'); // upcoming, ongoing, completed, canceled
            $table->boolean('is_featured')->default(false);
            $table->string('event_image')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('last_edited_by')->nullable();
            $table->foreign('last_edited_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
