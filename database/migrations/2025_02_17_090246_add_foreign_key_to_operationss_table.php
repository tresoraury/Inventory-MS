<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToOperationssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operationss', function (Blueprint $table) {
            $table->unsignedBigInteger('materiel_id')->change();
            $table->foreign('materiel_id')->references('id')->on('materiaux')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('operationss', function (Blueprint $table) {
            $table->dropForeign(['materiel_id']);
        });
    }
}
