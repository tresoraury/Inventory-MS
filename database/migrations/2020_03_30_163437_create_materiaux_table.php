<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMateriauxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the table already exists
        if (!Schema::hasTable('materiaux')) {
            Schema::create('materiaux', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('No_code');
                $table->string('designation');
                $table->string('unite_emploie');
                // Add other fields if necessary
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
        Schema::dropIfExists('materiaux');
    }
}