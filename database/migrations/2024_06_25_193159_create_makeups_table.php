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
            $table->text('notes')->nullable();
            $table->text('addService')->nullable();
            $table->integer('priceService')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->date('appropriate');
            $table->integer('pay');
            $table->integer('rest');
            $table->integer('total');
            $table->string('reason_discount')->nullable();
            $table->integer('price')->nullable();
            $table->time('enter')->nullable();
            $table->time('exit')->nullable();
            $table->string('status');
            $table->time('arrive')->nullable();
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
