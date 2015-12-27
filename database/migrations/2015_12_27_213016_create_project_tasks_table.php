<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_tasks', function (Blueprint $table) {
            $table->increments('id');

			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');

			$table->string('name');
			$table->dateTime('start_date');
			$table->dateTime('due_date');
			$table->smallInteger('status')->unsigned();
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
        Schema::drop('project_tasks');
    }
}
