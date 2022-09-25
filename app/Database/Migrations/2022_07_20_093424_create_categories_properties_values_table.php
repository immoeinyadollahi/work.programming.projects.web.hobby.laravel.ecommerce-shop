<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories_properties_values', function (Blueprint $table) {
            $table->id();
            $table->_orderable();
            $table->_foreignKey("property_value_id")->on("property_values")->cascadeOnDelete();
            $table->_foreignKey("category_property_id")->on("categories_properties")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('categories_properties_values');
    }
};
