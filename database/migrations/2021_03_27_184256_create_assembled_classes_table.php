<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssembledClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assembled_classes', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('student_id')->unsigned(); // foreign key
            $table->bigInteger('class_id')->unsigned(); // foreign key

            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->foreign('student_id')
                ->references('id')
                ->on('students');

            $table->foreign('class_id')
                ->references('id')
                ->on('classes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assembled_classes');
    }
}
