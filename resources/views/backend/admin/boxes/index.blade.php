@extends('layouts.dash')

@section('css')
    <link rel="stylesheet" href="/css/datatables.min.css">

    <style type="text/css">
        
        .button_green{
            background-color: green;
            color: green;
        }

        .button_red{
            background-color: red;
            color: red;
        }
    </style>
@stop

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            
            <!--mini statistics start-->
            <div class="row">
                                        
                <h2>Boxes Table</h2>
                
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Post Code</th>
                            <th>Status</th>                         
                        </tr>
                    </thead>

                    <tbody>
                        
                        @if($boxes->count())
                            @foreach($boxes as $box)
                            <tr>
                                
                                <td>{!! $box->number !!}</td>
                                <td>{!! $box->post_code !!}</td>
                                <td>
                                    @if($box->status == 1)
                                        <button class="button_green">
                                            <div style="color: #fff;">Box Taken</div>                                        
                                        </button>                                        
                                    @else
                                        <button class="button_red">
                                            <div style="color: #fff;">
                                                Box Available
                                            </div>
                                        </button>
                                        
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @endif
                        
                    </tbody>
                </table>

            </div>
            <!--mini statistics end-->
            {{ $boxes->links() }}

        </section>
    </section>
    <!--main content end-->

@stop

@section('js')
    @include('includes.js')

    <script src="/bs3/js/bootstrap.min.js"></script>
    <script src="/js/plugins.js"></script>

    <script src="/js/data-tables/datatables.min.js"></script>
    <script>
        $(function() {
            $('#example').DataTable();
        });
    </script>
@stop