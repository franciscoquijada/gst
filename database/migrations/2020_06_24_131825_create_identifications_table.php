<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identifications', function (Blueprint $table) {
            $table->id();
            $table->morphs('identifications');
            $table->unsignedInteger('identification_type_id');
            $table->string('value');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('identifications_types', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('name');
            $table->json('attr')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('identifications_types');
        Schema::dropIfExists('identifications');
    }
}
