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
            $table->unsignedBigInteger('inventory_id');
            $table->string('requester');
            $table->integer('quantity');
            $table->date('request_date');
            $table->string('item_name');
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('inventory_id')->references('id')->on('inventories');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supply_requests');
    }
};
