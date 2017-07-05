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

			$puzzle = $this->f_puzzle->createNewPuzzleRepository();
			$puzzle->setPuzzle($file_content_as_json);

			$this->info('Empty puzzle');
			$this
				->displayGrid(
					$puzzle->getPuzzleAsCollection()
				);
			$this->info(PHP_EOL);

			if ($puzzle->isSolvable())
			{
				$this->info('First solution with Xeeeveee\Sudoku\Puzzle package');

				$rustart = getrusage();

				$puzzle->solve();

				$this
					->displayGrid(
						$puzzle->getSolutionAsCollection()
					);

				$ru = getrusage();
				$this->info("This process used " . $this->rutime($ru, $rustart, "utime") . " ms for its computations");
				$this->info("It spent " . $this->rutime($ru, $rustart, "stime") . " ms in system calls");
			}

			/*
			 * Second solution with HomeMade package
			 */

			$this->info(PHP_EOL);
			$this->info('Second solution with HomeMade package');

			$resolver = $this->f_resolver->createNewResolverRepository();
			$resolver->setPuzzle($file_content_as_json);

			$rustart = getrusage();

			$this
				->displayGrid(
					$resolver->getSolutionAsCollection()
				);

			$ru = getrusage();
			$this->info("This process used " . $this->rutime($ru, $rustart, "utime") . " ms for its computations");
			$this->info("It spent " . $this->rutime($ru, $rustart, "stime") . " ms in system calls");
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

	/**
	 * @param \Illuminate\Support\Collection $collection
	 */
	protected function displayGrid(\Illuminate\Support\Collection $collection) {
		$collection
			->each(function($line, $row)
			{
				$this->info(implode(' | ', $line));
				if (8 !== $row)
				{
					$this->info('---------------------------------');
				}
			});
	}

	/**
	 * @param $ru
	 * @param $rus
	 * @param $index
	 *
	 * @return mixed
	 */
	protected function rutime($ru, $rus, $index) {
		return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
			-  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
	}
}
