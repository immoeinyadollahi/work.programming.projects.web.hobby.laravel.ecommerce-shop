<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('likes_dislikes', function (Blueprint $table) {
            $table->id();
            $table->boolean("is_liked");
            $table->morphs("target");
            $table->_foreignKey("user_id")->on("users")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('likes_dislikes');
    }
};
