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
        Schema::create('motameds', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hangar_id')->index('hangar_motamed_fk');
            $table->unsignedInteger('employee_id')->index('hangar_employee_fk');
			$table->string('name');
			$table->string('last_name')->nullable();
			$table->string('father_name');
			$table->string('position');
			$table->string('gender');
			$table->string('phone');
			$table->string('email');
			$table->unsignedInteger('directorate_id')->index('motamed_directorate_fk');
			$table->string('department', 50);
			$table->boolean('hire_status');
            $table->foreign('hangar_id', 'hangar_motamed_fk')->references('id')->on('hangars')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('employee_id', 'hangar_employee_fk')->references('id')->on('employees')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
			$table->foreign('directorate_id', 'motamed_directorate_fk')->references('id')->on('directorates')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('motameds');
    }
};
