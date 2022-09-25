<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->boolean("is_done", false);
            $table->integer("amount");
            $table->string("transaction_id");
            $table->string("email");
            $table->string("mobile");
            $table->string("description");
            $table->string("ref_id")->nullable();
            $table->_foreignKey("order_id")->on("orders")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('payment_transactions');
    }
};
