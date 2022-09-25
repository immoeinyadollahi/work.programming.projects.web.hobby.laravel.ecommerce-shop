<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('db_keys', function (Blueprint $table) {
            $table->id();
            $table->string("type");
            $table->string("table");
            $table->string("columns");
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('db_keys');
    }
};
