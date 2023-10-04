<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDonorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('donors', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name_en');
			$table->string('name_prs');
			$table->string('name_ps');
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
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
		Schema::dropIfExists('donors');
	}

}
