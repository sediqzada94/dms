<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('category_id')->index('item_balance_fk');
			$table->unsignedInteger('item_type_id')->index('item_balance_type_fk');
			$table->unsignedInteger('unit_of_measure_id')->index('unit_of_measure_balance_fk');
			$table->integer('quantity_threshold')->nullable();
			$table->string('code');
			$table->string('name_en');
			$table->string('name_ps');
			$table->string('name_prs');
			$table->text('description');
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
			$table->foreign('item_type_id', 'item_balance_type_fk')->references('id')->on('item_types')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('category_id', 'item_balance_fk')->references('id')->on('categories')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('unit_of_measure_id', 'unit_of_measure_balance_fk')->references('id')->on('unit_of_measures')->onUpdate('CASCADE')->onDelete('NO ACTION');
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
		Schema::dropIfExists('items');
	}

}
