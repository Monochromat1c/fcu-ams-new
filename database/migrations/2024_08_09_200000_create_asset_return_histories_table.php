<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asset_return_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->string('returned_by'); // assignee name or user id
            $table->string('received_by'); // new, for storing name/username
            $table->unsignedBigInteger('condition_id')->nullable();
            $table->date('return_date');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('asset_id')->references('id')->on('assets');
            $table->foreign('condition_id')->references('id')->on('conditions');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_return_histories');
    }
}; 