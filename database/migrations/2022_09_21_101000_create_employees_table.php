<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('last_name')->nullable();
			$table->string('father_name');
			$table->string('position');
			$table->string('gender');
			$table->string('phone');
			$table->string('email');
			$table->unsignedInteger('directorate_id')->index('employee_directorate_fk');
			$table->string('department');
			$table->boolean('hire_status');
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
			$table->foreign('directorate_id', 'employee_directorate_fk')->references('id')->on('directorates')->onUpdate('CASCADE')->onDelete('NO ACTION');
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
		Schema::dropIfExists('employees');
	}

}
