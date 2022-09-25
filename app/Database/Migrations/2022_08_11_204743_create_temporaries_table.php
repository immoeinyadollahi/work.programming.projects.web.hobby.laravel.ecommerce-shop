<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('temporaries', function (Blueprint $table) {
            $table->id();
            $table->json("data");
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('temporaries');
    }
};
