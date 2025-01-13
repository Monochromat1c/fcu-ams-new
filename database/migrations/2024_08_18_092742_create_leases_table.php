<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('leases', function (Blueprint $table) {
            $table->id();
            $table->date('lease_date');
            $table->date('lease_expiration');
            $table->string('customer');
            $table->string('contact_number');
            $table->string('email');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leases');
    }
};
