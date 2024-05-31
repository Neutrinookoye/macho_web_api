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
            $table->unsignedBigInteger('department_id')->nullable()->after('location_id');
        });
        \Illuminate\Support\Facades\DB::table('job_openings')->where('department_id', 0)->update(['department_id' => 1]);

        Schema::table('job_openings', function (Blueprint $table) {

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_openings', function (Blueprint $table) {
            //
            $table->dropForeign(['department_id']);
        });
    }
};
