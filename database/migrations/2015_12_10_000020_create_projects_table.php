<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');

	        $table->integer('owner_id')->unsigned();
	        $table->foreign('owner_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

	        $table->integer('client_id')->unsigned();
	        $table->foreign('client_id')->references('id')->on('clients')->onDelete('restrict')->onUpdate('cascade');

	        $table->string('name', 150);
	        $table->text('description');
	        $table->smallInteger('progress')->unsigned();
	        $table->smallInteger('status')->unsigned();
	        $table->date('due_date');

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
        Schema::drop('projects');
    }
}
