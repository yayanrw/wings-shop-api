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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('product_code', 18);
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('quantity')->default(0);
            $table->string('unit', 5);
            $table->unsignedBigInteger('sub_total')->default(0);
            $table->string('currency', 5);
            $table->timestamps();

            $table->foreign('product_code')->references('code')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
