@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
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

                    display sudoku here



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
