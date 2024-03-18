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
        Schema::table('job_openings', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('location_id')->nullable()->after('role');
        });
        \Illuminate\Support\Facades\DB::table('job_openings')->where('location_id', 0)->update(['location_id' => 1]);

        Schema::table('job_openings', function (Blueprint $table) {

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_openings', function (Blueprint $table) {
            //
            $table->dropForeign(['location_id']);
        });
    }
};
