<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaStoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_story', function (Blueprint $table) {
            $table->unsignedInteger('meta_id');
            $table->unsignedInteger('story_id');

            $table->foreign('meta_id')->references('id')->on('metas')
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
        Schema::dropIfExists('meta_story');
    }
}
