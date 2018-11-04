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
                                    
                                    <h3>Normal Users Signed</h3>
                                    
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                    
                                        <tbody>
                                            
                                                @if($normalUsers->count())
                                                    @foreach($normalUsers as $user)
                                                    <tr>
                                                        <td>{!! $user->first_name !!}</td>
                                                        <td>{!! $user->last_name !!}</td>
                                                        <td>{!! $user->email !!}</td>
                                                        <td>KES 62.50/-</td>
                                                    </tr>
                                                    @endforeach
                                                @endif
                                            
                                        </tbody>
                                    </table>

                                    <div class="pull-right" style="margin-right: 10%">
                                        <b>
                                            Total: KES {!! $normalRentorSum !!}
                                        </b>                                    
                                    </div>
                                    <br>

                                    <hr>
                                    <h3>Corporate Companies Signed</h3>
                                    
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                    
                                        <tbody>
                                            
                                                @if($corporatesUsers->count())
                                                    @foreach($corporatesUsers as $user)
                                                    <tr>
                                                        <td>{!! $user->first_name !!}</td>
                                                        <td>{!! $user->last_name !!}</td>
                                                        <td>{!! $user->email !!}</td>
                                                        <td>KES 150/-</td>
                                               
                                                    </tr>
                                                    @endforeach
                                                @endif
                                            
                                        </tbody>
                                    </table>
                                    <div class="pull-right" style="margin-right: 10%">
                                        <b>
                                            Total: KES {!! $corporateRentorSum !!}
                                        </b>                                    
                                    </div>
                                </div>

                                <br/>

                                <div>
                                    <div class="pull-right" style="margin-right: 7%; font-size:22px;">
                                        <b>
                                            Grand Total: KES {!! $totalSum !!}
                                        </b>                                    
                                    </div>
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
    
