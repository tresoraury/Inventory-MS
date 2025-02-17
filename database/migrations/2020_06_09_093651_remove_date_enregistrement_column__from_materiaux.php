<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveDateEnregistrementColumnFromMateriaux extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the column exists before attempting to drop it
        if (Schema::hasColumn('materiaux', 'date_enregistrement')) {
            Schema::table('materiaux', function (Blueprint $table) {
                $table->dropColumn('date_enregistrement');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materiaux', function (Blueprint $table) {
            $table->date('date_enregistrement')->nullable(); // Adjust as necessary
        });
    }
}