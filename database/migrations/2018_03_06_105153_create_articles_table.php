<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->text('text');
            $table->integer('category_id');
            $table->dateTime('date');
            $table->integer('user_id');
            $table->integer('file_id');
            $table->integer('views');
            $table->integer('a2_t_id');
            $table->enum('status', ['new', 'moderated', 'published', 'not_published', 'locked']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
