<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('property_values', function (Blueprint $table) {
            $table->id();
            $table->string("value");
            $table->_foreignKey("property_id")->on("properties")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('property_values');
    }
};
