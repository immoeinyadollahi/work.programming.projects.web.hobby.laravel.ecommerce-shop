<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ["simple", "variable"])->default("simple");
            $table->enum('status', ['auto-draft', 'draft', 'published'])->default("auto-draft");
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('brand_id')->nullable();
            $table->float('final_rating')->default(0);
            $table->float('avg_rating')->default(0);
            $table->float('sales')->default(0);
            $table->text('description')->nullable();
            $table->date('published_at')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
