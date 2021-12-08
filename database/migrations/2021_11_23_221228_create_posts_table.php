<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
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
	    $table->string('user_id')->nullable()->change();
	    $table->string('game_id')->nullable()->change();
	    $table->string('text');
	    $table->string('image')->nullable()->change();
	    $table->integer('reply_count')->nullable()->change();
	    $table->integer('fav_count')->nullable()->change();
	    $table->integer('parent_id')->nullable()->change();
	    $table->timestamps();
	    $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
