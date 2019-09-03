<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionItemsTable extends Migration
{
    public function up()
    {
        Schema::create('subscription_items', function (Blueprint $table) {
           $table->bigIncrements('id');
           $table->unsignedBigInteger('subscription_id');
           $table->string('stripe_id');
           $table->string('stripe_plan');
           $table->integer('quantity');
           $table->timestamps();

           $table->index(['subscription_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscription_items');
    }
}
