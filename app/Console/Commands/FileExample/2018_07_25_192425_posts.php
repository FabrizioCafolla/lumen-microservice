<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Posts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('posts', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('user_id')->unsigned();
		    $table->json('status')->comment('Status post: Active or Draft');


		    $table->string('title');
		    $table->string('description');

		    $table->timestamps();
		    $table->softDeletes();

		    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::drop('posts');
    }
}
