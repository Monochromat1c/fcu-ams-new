<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('maintenance_title');
            $table->string('maintenance_detail')->nullable();
            $table->date('maintenance_due_date');
            $table->string('maintenance_by');
            $table->string('maintenance_status');
            $table->date('date_completed')->nullable();
            $table->decimal('maintenance_cost', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('maintenances');
    }
};
