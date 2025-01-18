<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('conditions', function (Blueprint $table) {
            $table->id();
            $table->string('condition');
            $table->timestamps();
        });

        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_image')->nullable();
            $table->string('asset_tag_id');
            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->string('model');
            $table->text('specs')->nullable();
            $table->string('serial_number');
            $table->decimal('cost', 10, 2);
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->unsignedBigInteger('site_id');
            $table->foreign('site_id')->references('id')->on('sites');
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->date('purchase_date');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->unsignedBigInteger('condition_id')->nullable();
            $table->foreign('condition_id')->references('id')->on('conditions');
            $table->decimal('disposed_amount', 10, 2)->nullable();
            $table->date('maintenance_start_date')->nullable();
            $table->date('maintenance_end_date')->nullable();
            $table->string('assigned_to')->nullable();
            $table->date('issued_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('conditions');
        Schema::dropIfExists('statuses');
        Schema::dropIfExists('assets');
    }
};
