<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('auction', function (Blueprint $table) {
            $table->integer('bet_size')->default(1)->after('free_slots');
            $table->integer('all_slots')->default(0)->after('free_slots');
            $table->renameColumn('free_slots', 'busy_slots');
        });
    }

    public function down()
    {
        Schema::table('auction', function (Blueprint $table) {
            $table->dropColumn('bet_size');
            $table->dropColumn('all_slots');
            $table->renameColumn('busy_slots', 'free_slots');
        });
    }
};