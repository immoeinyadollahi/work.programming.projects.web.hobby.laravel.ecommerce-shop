<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories_specification_items', function (Blueprint $table) {
            $table->id();
            $table->string("default_value");
            $table->enum("default_value_type", ["text", "boolean"]);
            $table->_orderable();
            $table->_foreignKey("specification_item_id")->on("specification_items")->cascadeOnDelete();
            $table->_foreignKey("category_specification_id")->on("categories_specifications")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('categories_specification_items');
    }
};
