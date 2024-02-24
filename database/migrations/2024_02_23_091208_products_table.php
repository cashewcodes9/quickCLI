<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->integer('sku');
            $table->string('name');
            $table->multiLineString('description');
            $table->string('short_description');
            $table->float('price');
            $table->string('link');
            $table->string('image');
            $table->string('brand');
            $table->integer('rating');
            $table->string('caffeine_type')->nullable();
            $table->integer('count');
            $table->boolean('flavored');
            $table->boolean('seasonal');
            $table->boolean('in_stock');
            $table->boolean('facebook');
            $table->boolean('is_k_cup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('products');
    }
};
