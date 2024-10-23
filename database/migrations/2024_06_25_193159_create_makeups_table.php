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
        Schema::create('makeups', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->json('notes')->nullable();
            $table->text('addService')->nullable();
            $table->integer('priceService')->nullable();
            $table->date('dateService')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->date('appropriate');
            $table->integer('pay');
            $table->integer('rest');
            $table->integer('total');
            $table->integer('secondInstallment')->nullable();
            $table->timestamp('DateOfTheSecondInstallment')->nullable();
            $table->integer('thirdInstallment')->nullable();
            $table->timestamp('DateOfTheThirdInstallment')->nullable();
            $table->integer('reason_discount_id')->nullable();
            $table->integer('price')->nullable();
            $table->time('enter')->nullable();
            $table->time('exit')->nullable();
            $table->string('status');
            $table->time('arrive')->nullable();
            $table->string('typeHair')->nullable();
            $table->integer('priceHair')->nullable();
            $table->date('dateHair')->nullable();
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
        Schema::dropIfExists('makeups');
    }
};
