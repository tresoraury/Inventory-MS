<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveQuantiteColumnFromMateriaux extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the column exists before attempting to drop it
        if (Schema::hasColumn('materiaux', 'quantite')) {
            Schema::table('materiaux', function (Blueprint $table) {
                $table->dropColumn('quantite');
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
            $table->integer('quantite')->nullable(); // Optional: make it nullable if needed
        });
    }
}