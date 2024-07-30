<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvertedFilesTable extends Migration
{
    public function up()
    {
        Schema::create('converted_files', function (Blueprint $table) {
            $table->id();
            $table->string('original_filename');
            $table->string('converted_filename');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('converted_files');
    }
}
