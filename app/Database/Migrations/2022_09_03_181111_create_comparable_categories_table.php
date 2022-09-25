<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comparable_categories', function (Blueprint $table) {
            $table->id();
            $table->_foreignKey("category_id_1")->on("categories")->cascadeOnDelete();
            $table->_foreignKey("category_id_2")->on("categories")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('comparable_categories');
    }
};
