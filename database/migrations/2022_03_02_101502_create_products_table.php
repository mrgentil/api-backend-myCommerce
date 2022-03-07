<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('slug');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('brand');
            $table->string('selling_price');
            $table->string('original_price');
            $table->string('qte');
            $table->string('image')->nullable();
            $table->string('featured')->nullable()->default('0');
            $table->string('popular')->nullable()->default('0');
            $table->string('status')->nullable()->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
