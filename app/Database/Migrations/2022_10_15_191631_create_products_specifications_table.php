<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_specifications', function (Blueprint $table) {
            $table->id();
            $table->_orderable();
            $table->_foreignKey("specification_id")->on("specifications")->cascadeOnDelete();
            $table->_foreignKey("product_id")->on("products")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('products_specifications');
    }
};
