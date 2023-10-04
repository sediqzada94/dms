<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDirectoratesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('directorates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('name_en');
			$table->text('name_ps');
			$table->text('name_prs');
			$table->integer('parent_id');
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
		});
	}


	/**
	 * Reverse the migrations.  
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('directorates');
	}

}
