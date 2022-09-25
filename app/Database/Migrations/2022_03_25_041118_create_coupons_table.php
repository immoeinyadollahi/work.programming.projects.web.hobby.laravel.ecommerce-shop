<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('amount');
            $table->boolean('is_used')->default(false);
            $table->timestamp('expires_at')->default(null);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};
