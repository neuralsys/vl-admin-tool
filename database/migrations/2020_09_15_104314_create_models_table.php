<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->id();
            $table->string('class_name');
            $table->string('table_name');
            $table->text('description')->nullable();
            $table->boolean('timestamps')->default(true);
            $table->boolean('soft_delete')->default(true);
            $table->boolean('test')->default(true);
            $table->boolean('swagger')->default(false);
            $table->boolean('datatables')->default(true);
            $table->unsignedTinyInteger('paginate')->default(15);
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
        Schema::dropIfExists('models');
    }
}
