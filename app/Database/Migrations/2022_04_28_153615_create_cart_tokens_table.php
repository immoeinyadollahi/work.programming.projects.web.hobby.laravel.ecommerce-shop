<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cart_tokens', function (Blueprint $table) {
            $table->id();
            $table->integer("cart_id");
            $table->_tokenable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('cart_tokens');
    }
};
