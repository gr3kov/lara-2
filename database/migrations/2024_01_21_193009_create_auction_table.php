<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionTable extends Migration
{
    public function up()
    {
        Schema::create('auction', function (Blueprint $table) {
            $table->id();
            // Добавьте столбцы, необходимые для таблицы auction
            $table->string('name');
            $table->integer('price');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('auction');
    }
}
