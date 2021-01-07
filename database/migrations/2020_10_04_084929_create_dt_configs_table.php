<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDtConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dt_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field_id');
            $table->boolean('showable')->default(1);
            $table->boolean('searchable')->default(1);
            $table->boolean('orderable')->default(1);
            $table->boolean('exportable')->default(1);
            $table->boolean('printable')->default(1);
            $table->string('class')->nullable();
            $table->boolean('has_footer')->default(0);

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
        Schema::dropIfExists('dt_configs');
    }
}
