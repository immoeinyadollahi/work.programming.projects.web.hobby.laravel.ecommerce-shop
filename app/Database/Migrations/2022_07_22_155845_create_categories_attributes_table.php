<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories_attributes', function (Blueprint $table) {
            $table->id();
            $table->_orderable();
            $table->_foreignKey("category_id")->on("categories")->cascadeOnDelete();
            $table->_foreignKey("attribute_id")->on("attributes")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('categories_attributes');
    }
};
