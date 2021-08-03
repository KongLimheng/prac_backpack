<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->char('ref_id', 36)->nullable();
            $table->string('ref_resource', 191)->nullable();
            $table->char('salesforce_id', 36)->nullable();
            $table->timestamp('last_sync_modify')->nullable();
            $table->bigInteger('account_id')->unsigned()->nullable();
            $table->bigInteger('user_id_fk')->unsigned()->nullable();
            $table->boolean('is_vip')->nullable();
            $table->string('type',191)->nullable();
            $table->string('first_name',191)->nullable();
            $table->string('last_name',191)->nullable();
            $table->string('email', 191)->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('phone_3')->nullable();
            $table->string('phone_4')->nullable();
            $table->string('street_no',191)->nullable();
            $table->string('house_no',191)->nullable();
            $table->string('address',191)->nullable();
            $table->string('relationships')->nullable();
            $table->string('working_field')->nullable();
            $table->string('identity_card',191)->nullable();
            $table->string('identity_card_photos')->nullable();
            $table->string('profile',191)->nullable();
            $table->string('salutation',191)->nullable();
            $table->string('occupation',191)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->bigInteger('owner')->nullable();
            $table->string('assistan_name',191)->nullable();
            $table->string('deprtement',191)->nullable();
            $table->string('fax',191)->nullable();
            $table->string('lead_source',191)->nullable();
            $table->bigInteger('reports_to')->unsigned()->nullable();
            $table->string('remark',191)->nullable();
            $table->string('title',191)->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('owner_account_id')->unsigned()->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
