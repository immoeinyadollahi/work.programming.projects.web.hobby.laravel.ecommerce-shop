<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('phone_otp_tokens', function (Blueprint $table) {
            $table->id();
            $table->string("phone")->index();
            $table->_tokenable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('phone_otp_tokens');
    }
};
