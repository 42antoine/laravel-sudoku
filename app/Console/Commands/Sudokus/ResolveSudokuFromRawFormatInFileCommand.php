<?php

namespace sudoku\Console\Commands\Sudokus;

use Illuminate\Console\Command;

class ResolveSudokuFromRawFormatInFileCommand extends Command
{

	/**
	 * Command name.
	 *
	 * @var string
	 */
	protected $name = 'sudoku:resolve';

	/**
	 * Command signature.
	 *
	 * @var string
	 */
	protected $signature = 'sudoku:resolve {file : Path to the file that contains the sudoku (as raw format)}';

	/**
	 * Command description.
	 *
	 * @var string
	 */
	protected $description = 'Resolve a sudoku from a file (raw format)';

	/**
	 * Execute command.
	 */
	public function fire() {

		try {

			$file_path = $this->argument('file');

			if (!\File::exists($file_path))
			{
				throw new \Exception('The file doesn\'t exist');
			}

			$file_content = \File::get($file_path);

			$this->info($file_content);

		}
		catch (\Symfony\Component\Console\Exception\RuntimeException $exception)
		{
			$this->error($exception->getMessage());
		}
		catch (\Exception $exception)
		{
			$this->error($exception->getMessage());
		}
	}
}
