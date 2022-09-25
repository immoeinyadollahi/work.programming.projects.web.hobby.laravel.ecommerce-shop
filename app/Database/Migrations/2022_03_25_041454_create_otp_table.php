<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('otp', function (Blueprint $table) {
            $table->id();
            $table->string("phone");
            $table->string("code");
            $table->string("type");
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('otp');
    }
};
