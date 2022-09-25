<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories_attributes_values', function (Blueprint $table) {
            $table->id();
            $table->_orderable();
            $table->_foreignKey("attribute_value_id")->on("attribute_values")->cascadeOnDelete();
            $table->_foreignKey("category_attribute_id")->on("categories_attributes")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('categories_attributes_values');
    }
};
