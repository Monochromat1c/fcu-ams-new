<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('unit');
            $table->timestamps();
        });

        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('unique_tag');
            $table->string('stock_image')->nullable();
            $table->integer('quantity');
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->string('items_specs');
            $table->string('brand')->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->date('stock_out_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventories');
        Schema::dropIfExists('units');
    }
};
