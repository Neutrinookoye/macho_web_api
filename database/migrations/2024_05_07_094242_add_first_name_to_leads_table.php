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
        Schema::table('leads', function (Blueprint $table) {
            //
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->string('job_title')->after('last_name');
            $table->string('organization')->after('email');
            $table->string('country')->after('organization');
            $table->string('services')->after('country');
            $table->longText('brief')->after('services');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            //
        });
    }
};
