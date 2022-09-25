<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Classes\Base\Database\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('en');
            $table->string('fa');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->_orderable('level');
            $table->boolean("is_last_level")->default(false);
            // category order between other categories in same parent
            $table->_orderable('sibling_order');
            $table->_foreignKey("parent_id")->on("categories")->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
