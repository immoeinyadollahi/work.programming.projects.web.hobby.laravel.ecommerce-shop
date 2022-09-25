<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_sales', function (Blueprint $table) {
            $table->id();
            $table->integer("sale_cost");
            $table->_foreignKey("order_id")->on("orders")->cascadeOnDelete();
            $table->_foreignKey("product_id")->on("products")->cascadeOnDelete();
            $table->_foreignKey("user_id")->on("users")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('products_sales');
    }
};
