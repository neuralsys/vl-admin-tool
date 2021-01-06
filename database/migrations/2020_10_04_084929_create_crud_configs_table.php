<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrudConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crud_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field_id');
            $table->boolean('creatable')->default(1);
            $table->boolean('editable')->default(1);
            $table->string('rules');

            $table->foreign('field_id')->references('id')->on('fields');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crud_configs');
    }
}
