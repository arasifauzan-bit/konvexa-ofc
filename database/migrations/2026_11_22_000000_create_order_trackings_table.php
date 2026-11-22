<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_trackings', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 32)->unique();
            $table->char('phone_last_four', 4);
            $table->string('status', 32)->default('antrian');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_trackings');
    }
};
