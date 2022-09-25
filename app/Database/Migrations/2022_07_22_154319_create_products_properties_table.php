<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_properties', function (Blueprint $table) {
            $table->id();
            $table->_orderable();
            // for improving queries
            $table->integer("property_id");
            $table->_foreignKey("property_value_id")->on("property_values")->cascadeOnDelete();
            $table->_foreignKey("product_id")->on("products")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('products_properties');
    }
};
