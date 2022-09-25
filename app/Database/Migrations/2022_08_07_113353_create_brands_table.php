<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string("en");
            $table->string("fa");
            $table->string("slug");
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('brands');
    }
};
