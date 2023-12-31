<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('user_roles'))
        Schema::create('user_roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // $table->uuid('user_id')->index();
            $table->foreignUuid('user_id')->references('id')->on('users');
            // $table->uuid('role_id')->index();
            $table->foreignUuid('role_id')->references('id')->on('roles');
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
        Schema::dropIfExists('user_roles');
    }
};
