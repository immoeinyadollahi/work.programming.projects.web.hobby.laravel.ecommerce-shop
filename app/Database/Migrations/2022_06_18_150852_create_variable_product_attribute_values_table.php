<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('variable_product_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->_foreignKey("variable_product_attribute_id")->on("variable_product_attributes")->cascadeOnDelete();
            $table->_foreignKey("attribute_value_id")->on("attribute_values")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('variable_product_attribute_values');
    }
};
