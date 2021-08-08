<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('first_field_id');
            $table->unsignedBigInteger('second_field_id');
            $table->string('type');
            $table->string('table_name')->nullable();
            $table->string('fk_1')->nullable();
            $table->string('fk_2')->nullable();
            $table->timestamps();

            $table->unique(['first_field_id', 'second_field_id']);
            $table->foreign('first_field_id')->references('id')->on('fields');
            $table->foreign('second_field_id')->references('id')->on('fields');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relations');
    }
}
