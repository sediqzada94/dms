<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('item_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name_en', 32);
			$table->string('name_ps', 32);
			$table->string('name_prs', 32);
			$table->string('slug')->unique();
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
		Schema::dropIfExists('item_types');
	}

}
