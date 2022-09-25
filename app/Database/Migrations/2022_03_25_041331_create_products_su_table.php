<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_su', function (Blueprint $table) {
            $table->id();
            $table->_foreignKey("product_id")->on("products")->cascadeOnDelete();
            $table->enum('product_type', ["simple", "variable"]);
            $table->integer('price')->nullable();
            $table->integer('sale_price')->nullable();
            $table->integer('discounted_price')->nullable();
            $table->integer('discount_price')->nullable();
            $table->integer('discount_percent')->nullable();
            $table->timestamp('discount_expire')->nullable();
            $table->integer('stock')->nullable();
            $table->boolean('is_active')->default(false);
            $table->text('description')->nullable();
            $table->_orderable()->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('products_su');
    }
};
