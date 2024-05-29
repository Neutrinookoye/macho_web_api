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
            $table->string('logo')->default('noimage.jpg')->after('slug')->nullable(); 
            $table->string('page_bg')->default('noimage.jpg')->after('logo')->nullable();
            $table->string('page_bg2')->default('noimage.jpg')->after('page_bg')->nullable();
            $table->string('document')->default('nodocument.pdf')->after('outcome')->nullable();
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
