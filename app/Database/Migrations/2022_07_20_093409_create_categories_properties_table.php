<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories_properties', function (Blueprint $table) {
            $table->id();
            $table->_orderable();
            $table->_foreignKey("category_id")->on("categories")->cascadeOnDelete();
            $table->_foreignKey("property_id")->on("properties")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('categories_properties');
    }
};
