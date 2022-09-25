<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('property_groups', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('property_groups');
    }
};
