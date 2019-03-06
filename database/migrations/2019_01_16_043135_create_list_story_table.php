<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListStoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_story', function (Blueprint $table) {
            $table->unsignedInteger('list_id');
            $table->unsignedInteger('story_id');

            $table->foreign('list_id')->references('id')->on('save_lists')
                ->onDelete('cascade');
            $table->foreign('story_id')->references('id')->on('stories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_story');
    }
}
