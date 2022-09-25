<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_specification_group_items', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("value");
            $table->enum("type", ["text", "boolean"]);
            $table->_orderable();
            $table->_foreignKey("group_id")->on("product_specification_groups")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('product_specification_group_items');
    }
};
