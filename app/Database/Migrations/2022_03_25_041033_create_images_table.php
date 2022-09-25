<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('path')->nullable();
            $table->string('url');
            $table->string('original_name')->nullable();
            $table->string('disk')->nullable();
            $table->nullableMorphs("target");
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('image');
    }
};
