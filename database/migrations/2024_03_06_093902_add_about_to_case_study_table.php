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
            $table->longText('about')->after('page_bg2');
            $table->longText('brief')->after('about');
            $table->longText('solution')->after('brief');
            $table->longText('outcome')->after('solution');
            $table->longText('caption')->after('document');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('case_study', function (Blueprint $table) {
            //
        });
    }
};
