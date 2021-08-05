<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ref_id')->nullable();
            $table->string('ref_resource')->nullable();
            $table->char('salesforc_id')->nullable();
            $table->string('address');
            $table->string('campaign')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->string('salutation')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->bigInteger('owner');
            $table->string('phone')->nullable();
            $table->string('business_phone')->nullable();
            $table->string('lead_type');
            $table->string('industry')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('leads');
    }
}
