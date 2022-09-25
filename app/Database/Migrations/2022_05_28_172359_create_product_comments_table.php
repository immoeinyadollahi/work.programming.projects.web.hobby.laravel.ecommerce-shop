<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_comments', function (Blueprint $table) {
            $table->id();
            $table->integer("rating");
            $table->text("text");
            $table->boolean("is_verified")->default(false);
            $table->_foreignKey("user_id")->on("users")->cascadeOnDelete();
            $table->_foreignKey("product_id")->on("products")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('product_comments');
    }
};
