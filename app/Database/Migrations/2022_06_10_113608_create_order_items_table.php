<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->integer('product_su_price');
            $table->integer('product_su_discounted_price')->nullable();
            $table->_foreignKey("order_id")->on("orders")->cascadeOnDelete();
            $table->_foreignKey("product_su_id")->on("products_su")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
