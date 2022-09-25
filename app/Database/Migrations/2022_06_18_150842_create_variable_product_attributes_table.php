<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('variable_product_attributes', function (Blueprint $table) {
            $table->id();
            $table->_orderable();
            $table->_foreignKey("attribute_id")->on("attributes")->cascadeOnDelete();
            $table->_foreignKey("product_id")->on("products")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('variable_product_attributes');
    }
};
