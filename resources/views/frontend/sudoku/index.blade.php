@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Settings
                </div>
                <div class="panel-body">
                    <form role="form" method="GET" action="{{ url('/sudoku') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Difficulty</label>
                            {{ Form::select('cell_size', ['25' => 'Easy', '15' => 'Medium', '5' => 'Hard'], $selectedCellSize, ["style" => "width:100%"]) }}
                        </div>
                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn btn-primary">Apply</button>
                                <a class="btn btn-link" href="{{ url('/sudoku') }}">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Let's play !

                    <div class="pull-right">
                        @if (true === $isSolvable)
                            <span class="help-block" style="color:green;">
                                You can do it ! <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="In prevention to propose to you an unsolvable sudoku, we indicate the sudoku state, in case we got a bug." style="cursor:pointer"></i>
                            </span>
                        @else
                            <span class="help-block" style="color:red;">
                                Impossible to resolve this one, please refresh to find another puzzle <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="In prevention to propose to you an unsolvable sudoku, we indicate the sudoku state, in case we got a bug." style="cursor:pointer"></i>
                            </span>
                        @endif
                    </div>

                </div>

                <div class="panel-body">

                    <div class="row">

                        <div class="col-md-2">&nbsp;</div>

                        <div class="col-md-8">
                            <table width="100%" border="1" class="sudoku_grid">

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
                        </div>

                        <div class="col-md-2">&nbsp;</div>

                    </div>


                </div>

                <div class="panel-footer">

                    <button type="submit" class="btn btn-primary">Finish later</button>

                    <span class="pull-right">
                        <a class="btn btn-link" href="{{ url('/sudoku') }}">
                            Reset
                        </a>
                        <button type="submit" class="btn btn-primary">Check your solution</button>
                    </span>

                    <div class="clearfix"></div>

                </div>
            </div>
        </div>
        <div class="col-md-1">&nbsp;</div>
    </div>
</div>
@endsection
