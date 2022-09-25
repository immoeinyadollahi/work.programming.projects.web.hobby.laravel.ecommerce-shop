<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->integer('product_su_sale_price');
            $table->_foreignKey("cart_id")->on("carts")->cascadeOnDelete();
            $table->_foreignKey("product_su_id")->on("products_su")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};
