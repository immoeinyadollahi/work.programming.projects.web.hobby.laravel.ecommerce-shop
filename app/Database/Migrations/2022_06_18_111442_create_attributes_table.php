<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string("en");
            $table->string("fa");
            $table->boolean('is_custom')->default(false);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('attributes');
    }
};
