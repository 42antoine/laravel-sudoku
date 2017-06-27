<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSudokusSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('sudokus_settlements', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('sudoku_id')->unsigned();
			$table->enum('state', ['in_progress', 'solved']);
			$table->integer('nb_solution_unveiled');
			$table->timestamps();

			/*
			 * user_id foreign key
			 */

			$table
				->foreign('user_id')
				->references('id')
				->on('users')
				->onUpdate('cascade')
				->onDelete('cascade');

			/*
			 * sudoku_id foreign key
			 */

			$table
				->foreign('sudoku_id')
				->references('id')
				->on('sudokus')
				->onUpdate('cascade')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('sudokus_settlements');
    }
}
