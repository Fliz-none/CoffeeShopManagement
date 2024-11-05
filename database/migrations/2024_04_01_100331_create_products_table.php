<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->string('name');
            $table->text('excerpt')->nullable();
            $table->decimal('price', 10, 0)->default(0);
            $table->longText('description')->nullable();
            $table->text('gallery')->nullable();
            $table->unsignedInteger('sort')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->tinyInteger('status')->coment('0: block; 1: active')->default(1);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies');
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
}
