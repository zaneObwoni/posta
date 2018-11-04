@extends('layouts.dash')

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div id="job-history" class="tab-pane ">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="margin-left:-3%">
                                <div class="row">

                                    <h2>Agents Earning</h2>
                                    
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>ID Number</th>
                                                <th>Commission Amount</th>
                                            </tr>
                                        </thead>
                    
                                        <tbody>
                                            
                                                @if($agents->count())
                                                    @foreach($agents as $user)
                                                    <tr>
                                                        <td>{!! $user->first_name." " !!}{!! $user->first_name !!}</td>
                                                        <td>{!! $user->email !!}</td>
                                                        <td>{!! $user->phone !!}</td>
                                                        <td>{!! $user->identification_number !!}</td>
                                                        <td>
                                                            {!! $yazu !!}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endif
                                            
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--mini statistics end-->            
        </section>
    </section>
    <!--main content end-->    

@stop

@section('js')
    @include('includes.js')
@stop
    
            