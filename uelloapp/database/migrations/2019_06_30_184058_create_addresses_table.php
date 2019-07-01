<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer( 'client_id' );
            $table->string( 'address' );
            $table->string( 'number' );
            $table->string( 'complement' )->nullable();
            $table->string( 'neighborhood' );
            $table->string( 'city' );
            $table->string( 'zip_code' );
            $table->string( 'latitude' );
            $table->string( 'longitude' );
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
        Schema::dropIfExists('addresses');
    }
}
