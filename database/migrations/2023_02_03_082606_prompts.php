<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Prompts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prompts', function (Blueprint $table) {
            $table->increments('id');
            //$table->integer('project_id')->unsigned()->index();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->integer('number');
            $table->string('title');             
            $table->longText('content'); 
            $table->string('token'); 
            $table->enum('active', [0, 1])->default(1);           
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
       Schema::dropIfExists('prompts');        
    }
}
