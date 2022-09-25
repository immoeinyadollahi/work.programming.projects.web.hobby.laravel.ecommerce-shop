<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reset_password_tokens', function (Blueprint $table) {
            $table->id();
            $table->string("email")->index();
            $table->_tokenable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('reset_password_tokens');
    }
};
