<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_warranties', function (Blueprint $table) {
            $table->id();
            $table->string("en");
            $table->string("fa");
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('product_warranties');
    }
};
