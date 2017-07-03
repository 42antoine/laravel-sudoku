<?php

namespace sudoku\Console\Commands\Sudokus;

use Illuminate\Console\Command;
use sudoku\Domain\Sudokus\Puzzles\
{
	Factories\PuzzlesFactory
};
use sudoku\Domain\Sudokus\Resolvers\Factories\ResolversFactory;

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
	 * @var null|PuzzlesFactory
	 */
	protected $f_puzzle = null;

	/**
	 * @var null|ResolversFactory
	 */
	protected $f_resolver = null;

	/**
	 * ResolveSudokuFromRawFormatInFileCommand constructor.
	 *
	 * @param PuzzlesFactory $f_puzzle
	 */
	public function __construct(
		PuzzlesFactory $f_puzzle,
		ResolversFactory $f_resolver
	) {
		parent::__construct();

		$this->f_puzzle = $f_puzzle;
		$this->f_resolver = $f_resolver;
	}

	/**
	 * Execute command.
	 */
	public function fire() {

		try
		{

			$file_path = $this->argument('file');

			if (!\File::exists($file_path))
			{
				throw new \Exception('The file doesn\'t exist');
			}

			$file_content = \File::get($file_path);
			$file_content_as_json = json_decode($file_content);

			/*
			 * First solution with Xeeeveee\Sudoku\Puzzle package
			 */

			$this->info('First solution with Xeeeveee\Sudoku\Puzzle package');

			$puzzle = $this->f_puzzle->createNewPuzzleRepository();
			$puzzle->setPuzzle($file_content_as_json);

			if ($puzzle->isSolvable())
			{
				$puzzle->solve();
				$puzzle
					->getSolutionAsCollection()
					->each(function($line, $row) {
						$this->info(implode(' | ', $line));
						if (8 !== $row)
						{
							$this->info('---------------------------------');
						}
					});
			}

			/*
			 * Second solution with HomeMade package
			 */

			$this->info(PHP_EOL);
			$this->info('Second solution with HomeMade package');

			$resolver = $this->f_resolver->createNewResolverRepository();
			$resolver->setPuzzle($file_content_as_json);
			$resolver
				->getSolutionAsCollection()
				->each(function($line, $row) {
					$this->info(implode(' | ', $line));
					if (8 !== $row)
					{
						$this->info('---------------------------------');
					}
				});
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
