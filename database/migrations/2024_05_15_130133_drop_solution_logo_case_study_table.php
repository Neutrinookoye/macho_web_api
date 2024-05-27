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
        Schema::table('case_study', function (Blueprint $table) {
            //
            $table->dropColumn('logo');
            $table->dropColumn('page_bg');
            $table->dropColumn('page_bg2');
            $table->dropColumn('document');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
