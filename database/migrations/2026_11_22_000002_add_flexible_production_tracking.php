<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_trackings', function (Blueprint $table) {
            $table->text('progress_note')->nullable();
        });

        DB::table('order_trackings')
            ->whereIn('status', ['jahit', 'bordir'])
            ->update(['status' => 'produksi']);
    }

    public function down(): void
    {
        DB::table('order_trackings')
            ->where('status', 'produksi')
            ->update(['status' => 'jahit']);

        Schema::table('order_trackings', function (Blueprint $table) {
            $table->dropColumn('progress_note');
        });
    }
};
