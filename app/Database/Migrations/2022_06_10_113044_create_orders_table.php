<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->json('info');
            $table->enum("status", ['delivered', 'canceled', 'pending', 'returned', 'processing'])->default("pending");
            $table->enum('payment_method', ['on-delivering', 'online']);
            $table->text('description')->nullable();
            $table->_foreignKey("user_id")->on("users")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
