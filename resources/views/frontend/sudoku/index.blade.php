@extends('layouts.app')

@section('js')
    <script src="{{ mix('js/index.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <form role="form" method="GET" action="{{ url('/sudoku') }}">
                    {{ csrf_field() }}
                    <div class="panel-heading">
                        Settings
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Difficulty</label>
                            {{ Form::select('cell_size', ['25' => 'Easy', '15' => 'Medium', '5' => 'Hard'], $selectedCellSize, ["style" => "width:100%"]) }}
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">Apply</button>
                        <a class="btn btn-link" href="{{ url('/sudoku') }}">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Raw sudoku
                </div>
                <div class="panel-body">
                    <textarea cols="30" rows="6">{{ $thePuzzleAsRaw }}</textarea>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#showSolution">
                        Show raw solution ?
                    </button>
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

                            <div id="js-react-sudoku-error_message" class="pull-center" style="text-align:center;display:none;">
                                <div class="alert alert-danger" role="alert">This is not the good solution, try again !</div>
                            </div>

                            <div id="js-react-sudoku-success_message" class="pull-center" style="text-align:center;display:none;">
                                <div class="alert alert-success" role="alert">You did it !</div>
                            </div>

                            @include('frontend.sudoku.partials.sudoku_grid', ['thePuzzle' => $thePuzzle, 'theSolution' => $theSolution])

                            {{--<div id="js-react-sudoku-help" class="pull-center" style="text-align: center;"> Todo xABE show help ReactJs </div>--}}

                        </div>
                        <div class="col-md-2">&nbsp;</div>
                    </div>
                </div>
                <div class="panel-footer">
                    <span class="pull-left">

                        <a class="btn btn-link" href="{{ url('/sudoku') }}">
                            <i class="fa fa-refresh" aria-hidden="true"></i> Try another sudoku
                        </a>

                        {{--<button type="submit" class="btn btn-primary">Finish later</button>--}}
                    </span>
                    <span class="pull-right">
                        <a href="javascript:void(0);" class="btn btn-primary" id="js-sudoku-submit-sudoku-check-solution">Check your solution</a>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="col-md-1">&nbsp;</div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="showSolution" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">The raw solution for the current sudoku</h4>
            </div>
            <div class="modal-body">
                <textarea cols="30" rows="3" style="width:100%">{{ $theSolutionAsRaw }}</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
