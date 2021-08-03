<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable();
            $table->string('account_number', 255)->nullable();
            $table->string('bank_branch', 255)->nullable();
            $table->string('billing_address', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->dateTime('valid_until')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('industry')->nullable();
            $table->string('rating', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('description')->nullable();
            $table->integer('lft')->nullable();
            $table->integer('rgt')->nullable();
            $table->integer('depth')->nullable();
            $table->string('annual_revenur')->nullable();
            $table->string('number_of_employees', 255)->nullable();
            $table->string('fax', 255)->nullable();
            $table->string('ownership')->nullable();
            $table->string('sic')->nullable();
            $table->string('ticker_symbol', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->bigInteger('owner')->nullable();
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();            
            $table->string('logo')->nullable();
            $table->string('alias')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('accounts');
    }
}
