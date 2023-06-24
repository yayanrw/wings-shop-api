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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->string('document_code', 3);
            $table->string('document_number', 10);
            $table->string('product_code', 18);
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('quantity')->default(0);
            $table->string('unit', 5);
            $table->unsignedBigInteger('sub_total')->default(0);
            $table->string('currency', 5);
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
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
        Schema::dropIfExists('transaction_details');
    }
};
