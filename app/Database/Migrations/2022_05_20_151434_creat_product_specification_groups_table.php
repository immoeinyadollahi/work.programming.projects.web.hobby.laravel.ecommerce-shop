<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_specification_groups', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->_orderable();
            $table->_foreignKey("product_id")->on("products")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('product_specification_groups');
    }
};
