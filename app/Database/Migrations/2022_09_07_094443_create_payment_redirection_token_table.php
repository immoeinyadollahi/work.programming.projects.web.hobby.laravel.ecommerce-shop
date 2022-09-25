<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_redirection_token', function (Blueprint $table) {
            $table->id();
            $table->string("method");
            $table->string("action");
            $table->json("inputs");
            $table->_tokenable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('payment_redirection_token');
    }
};
