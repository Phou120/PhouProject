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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('food_id');
            $table->unsignedBigInteger('purchase_id');
            $table->integer('qty');
            $table->double('price');
            $table->double('sub_total');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('food_id')->references('id')->on('food')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('purchase_id')->references('id')->on('purchase_orders')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_details');
    }
};
