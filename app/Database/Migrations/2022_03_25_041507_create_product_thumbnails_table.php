<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_thumbnails', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('url');
            $table->_orderable();
            $table->string('original_name')->nullable();
            $table->_foreignKey("product_id")->on("products")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('product_thumbnails');
    }
};
