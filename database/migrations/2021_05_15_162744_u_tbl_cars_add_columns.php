<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UTblCarsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_types', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('picture_uri');
            $t->timestamps();
        });

        Schema::table('cars', function (Blueprint $t) {
            $t->string('picture_uri')->after('seats');
            $t->unsignedInteger('year')->after('model_id');
            $t->string('color', 7)->nullable()->after('price');
            $t->unsignedBigInteger('type_id')->after('model_id');

            $t->foreign('type_id')->references('id')->on('car_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cars', function (Blueprint $t) {
            $t->dropColumn('year');
            $t->dropColumn('color');
            $t->dropForeign('cars_type_id_foreign');
            $t->dropColumn('type_id');
        });

        Schema::dropIfExists('car_types');
    }
}
