<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paste_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
                
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('title');
            $table->string('hash')->unique();
            $table->string('original_link');
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
        Schema::dropIfExists('links');
    }
}
