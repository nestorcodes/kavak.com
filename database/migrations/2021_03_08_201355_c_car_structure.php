<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CCarStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_brands', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('picture_uri')->nullable();
            $t->timestamps();
        });

        Schema::create('car_models', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->unsignedBigInteger('brand_id');
            $t->timestamps();

            $t->foreign('brand_id')->references('id')->on('car_brands')->onDelete('cascade');
        });

        Schema::create('cars', function (Blueprint $t) {
            $t->id();
            $t->unsignedInteger('status_id')->default(1); // 1 Activo, 0 Inactivo, 2 Vendido
            $t->unsignedBigInteger('model_id');
            $t->unsignedBigInteger('creator_id');
            $t->unsignedBigInteger('buyer_id')->nullable();
            $t->decimal('price')->default(0);
            $t->unsignedInteger('transmission')->nullable();
            $t->string('motor')->nullable();
            $t->string('traction')->nullable();
            $t->text('details')->nullable();
            $t->integer('horse_power')->nullable();
            $t->unsignedInteger('gas_type')->nullable();
            $t->integer('seats')->nullable();
            $t->timestamps();

            $t->foreign('model_id')->references('id')->on('car_models')->onDelete('cascade');
            $t->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $t->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('user_favorite_cars', function (Blueprint $t) {
            $t->unsignedBigInteger('user_id');
            $t->unsignedBigInteger('car_id');

            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $t->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_favorite_cars');
        Schema::dropIfExists('cars');
        Schema::dropIfExists('car_models');
        Schema::dropIfExists('car_brands');
    }
}
