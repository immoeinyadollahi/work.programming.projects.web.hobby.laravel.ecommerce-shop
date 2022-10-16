<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_specification_items', function (Blueprint $table) {
            $table->id();
            $table->string("value");
            $table->enum("value_type", ["text", "boolean"]);
            $table->_orderable();
            $table->_foreignKey("specification_item_id")->on("specification_items")->cascadeOnDelete();
            $table->_foreignKey("product_specification_id")->on("product_specifications")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('products_specification_items');
    }
};
