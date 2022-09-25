<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('variable_product_su_attributes', function (Blueprint $table) {
            $table->id();
            $table->_orderable();
            // for improving queries
            $table->integer("attribute_id");
            $table->_foreignKey("attribute_value_id")->on("attribute_values")->cascadeOnDelete();
            $table->_foreignKey("product_su_id")->on("products_su")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('variable_product_su_attributes');
    }
};
