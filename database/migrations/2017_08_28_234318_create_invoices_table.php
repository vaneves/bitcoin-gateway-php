<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('code', 32)->unique()->index();
            $table->string('address', 64)->unique()->index();
            $table->string('reference', 64)->index();
            $table->double('total', 10, 8);
            $table->double('fee', 10, 8);
            $table->integer('status')->default(0);
            $table->string('notification_url', 128);
            $table->string('buyer_name', 128);
            $table->string('buyer_email', 128);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
