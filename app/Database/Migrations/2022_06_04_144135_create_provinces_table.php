<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug");
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('provinces');
    }
};
