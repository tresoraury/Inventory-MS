<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTableOperations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the table exists before attempting to drop it
        if (Schema::hasTable('operations')) {
            Schema::drop('operations');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optionally, you can recreate the operations table here if needed
        Schema::create('operations', function (Blueprint $table) {
            $table->increments('id');
            // Add other columns as necessary
        });
    }
}