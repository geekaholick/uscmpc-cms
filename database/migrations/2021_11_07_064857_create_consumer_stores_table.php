<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumerStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumer_stores', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->float('price_item');
            $table->float('price_batch');
            $table->string('description');
            $table->enum('status', ['active','inactive','removed']);   // {"active=1", "inactive=0", "removed:2"}					
            $table->date('effective_date');
            $table->timestamps();

       				
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumer_stores');
    }
}
