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
            $table->uuid('request_id')->unique(); // Unique ID for each item
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('inventory_id')->constrained('inventories');
            $table->string('requester');
            $table->integer('quantity');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->date('request_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supply_requests');
    }
};
