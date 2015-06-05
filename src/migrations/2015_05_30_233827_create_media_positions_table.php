<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaPositionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media_positions', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('position', 200)->nullable();
			$table->integer('order')->nullable();
			$table->string('file_path', 500)->nullable();
			$table->string('url', 500)->nullable();
			$table->text('other', 65535)->nullable();
			$table->string('attr_class', 200)->nullable();
			$table->string('attr_id', 200)->nullable();
			$table->string('other_atts', 500)->nullable();
			$table->dateTime('start_date')->nullable();
			$table->dateTime('end_date')->nullable();
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
		Schema::drop('media_positions');
	}

}
