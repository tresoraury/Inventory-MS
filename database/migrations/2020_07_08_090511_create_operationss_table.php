<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operationss', function (Blueprint $table) {
            $table->increments('id_operation');
            $table->string('materiel_id');
            $table->string('type_operation');
            $table->string('designation');
            $table->string('partenaire');
            $table->date('date_operation');
            $table->integer('quantite');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operationss');
    }
}
