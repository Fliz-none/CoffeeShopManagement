<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('avatar')->nullable();
            $table->unsignedTinyInteger('gender')->comment('0:male; 1:female; 2:other')->default(0);
            $table->string('password')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedTinyInteger('level')->comment('0: đồng; 1: bạc; 2: vàng; 3:kim cương')->default(0);
            $table->unsignedTinyInteger('status')->comment('0:block; 1:active')->default(1);
            $table->dateTime('last_login_at')->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->constrained()->onDelete('restrict');
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
