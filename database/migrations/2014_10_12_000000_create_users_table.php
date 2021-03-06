<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 200)->nullable();
            $table->json('attr')->nullable();
            $table->datetime('last_login_at')->nullable();
            $table->string('last_login_ip', 20)->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

            $table->index(["group_id"], 'companias_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
