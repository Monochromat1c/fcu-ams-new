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
            $table->uuid('request_group_id'); // Group ID to track items requested together
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('inventory_id')->constrained('inventories');
            $table->string('item_name'); // Store the actual requested item name
            $table->string('requester');
            $table->integer('quantity');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->date('request_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supply_requests');
    }
};
