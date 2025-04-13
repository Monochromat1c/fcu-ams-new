<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asset_turnover_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->string('previous_assignee');
            $table->string('new_assignee');
            $table->dateTime('turnover_date');
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_turnover_history');
    }
}; 