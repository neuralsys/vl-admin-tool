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
            $table->string('type');
            $table->unsignedBigInteger('first_model_id');
            $table->string('first_foreign_key');
            $table->unsignedBigInteger('second_model_id');
            $table->string('second_foreign_key');
            $table->string('table_name')->nullable();
            $table->string('first_key')->nullable();
            $table->string('second_key')->nullable();
            $table->timestamps();
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
