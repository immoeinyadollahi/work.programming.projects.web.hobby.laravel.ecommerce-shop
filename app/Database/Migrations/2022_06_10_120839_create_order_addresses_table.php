<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_fullname');
            $table->string('recipient_email');
            $table->string('recipient_phone');
            $table->string('postal_address');
            $table->string('postal_code');
            $table->_foreignKey("order_id")->on("orders")->cascadeOnDelete();
            $table->_foreignKey("city_id")->on("cities")->cascadeOnDelete();
            $table->_foreignKey("province_id")->on("provinces")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('order_addresses');
    }
};
