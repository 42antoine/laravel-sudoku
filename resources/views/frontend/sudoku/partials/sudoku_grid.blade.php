<table width="100%" border="1" id="js-sudoku_grid" class="sudoku_grid">

	@foreach ($thePuzzle as $key_row => $row)

		<tr>

			@foreach ($row as $key_column => $column)

				@if (0 === $column)
					<td align="center" style="vertical-align: middle;" height="35px">
						<input type="text" style="width: 100%; padding:10px;" name="sudoky_column[{{ $key_row }}][{{ $key_column }}]" data-key_row="{{ $key_row }}" data-key_column="{{ $key_column }}" data-value="{{ $column }}" data-solution="{{ $theSolution->get($key_row)[$key_column] }}">
					</td>
				@else
					<td align="center" style="vertical-align: middle;background-color:lightblue;" height="35px">
						{{ $column }}
						<input type="hidden" name="sudoky_column[{{ $key_row }}][{{ $key_column }}]" value="{{ $column }}" data-key_row="{{ $key_row }}" data-key_column="{{ $key_column }}" data-value="{{ $column }}" data-solution="{{ $column }}">
					</td>
				@endif

			@endforeach

		</tr>

	@endforeach

</table>
