<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_trackings', function (Blueprint $table) {
            $table->string('customer_name', 100)->nullable();
        });

        Schema::table('order_trackings', function (Blueprint $table) {
            $table->dropColumn('phone_last_four');
        });
    }

    public function down(): void
    {
        Schema::table('order_trackings', function (Blueprint $table) {
            $table->char('phone_last_four', 4)->nullable();
        });

        Schema::table('order_trackings', function (Blueprint $table) {
            $table->dropColumn('customer_name');
        });
    }
};
