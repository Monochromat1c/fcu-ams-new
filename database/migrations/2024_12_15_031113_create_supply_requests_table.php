<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('supply_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('request_id');
            $table->uuid('request_group_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('inventory_id')->nullable();
            $table->string('requester');
            $table->integer('quantity');
            $table->date('request_date');
            $table->string('item_name');
            $table->decimal('estimated_unit_price', 10, 2)->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('set null');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supply_requests');
    }
};
