@extends('layouts.dash')

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            
            <!--mini statistics start-->
            <div class="row">
                <div class="col-md-12">
                    <div class="mini-stat clearfix">
                        <a href="#" title="Click for more details">
                        <span class="mini-stat-icon orange"><i class=
                        "fa fa-gavel"></i></span>
                        <div class="mini-stat-info">
                            <span>{!! $letters !!}</span> Number of Estamps Sold for this Post Office
                        </div>
                            </a>
                    </div>

                </div>


                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <span class="mini-stat-icon green"><i class=
                        "fa fa-eye"></i></span>
                        <div class="mini-stat-info">
                            <span>{!! $normalRentors !!}</span> Number of Individual Boxes Rented
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <span class="mini-stat-icon green"><i class=
                        "fa fa-eye"></i></span>
                        <div class="mini-stat-info">
                            <span>{!! $corporateRentors !!}</span> Number of Corporate Boxes Rented
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <span class="mini-stat-icon green">
                        <i class="fa fa-eye"></i></span>
                        <div class="mini-stat-info">
                            <span>KES. {!! $estamps_sum !!}</span>
                            <div>
                                <h5>
                                    <b>
                                        Total value of Estamps Sold
                                    </b>                                    
                                </h5>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <span class="mini-stat-icon green">
                        <i class="fa fa-eye"></i></span>
                        <div class="mini-stat-info">
                            <span>KES. {!! $accounts_sum !!}</span> 
                            <div>
                                <h5>
                                    <b>
                                        Total value of Boxes Allocated 
                                    </b>                                    
                                </h5>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <span class="mini-stat-icon green">
                            <i class="fa fa-eye"></i>
                        </span>
                        <div class="mini-stat-info">
                            <span style="margin-top:3%">
                                <a href="{!! route('pm.boxes') !!}">
                                    Picked and Unpicked Boxes
                                </a>                                
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <span class="mini-stat-icon green">
                            <i class="fa fa-eye"></i>
                        </span>
                        <div class="mini-stat-info">
                            <span style="margin-top:3%">
                                <a href="/user/agent/collection/2016-06-01/2018-12-31">
                                    Estamps handled by Agents
                                </a>                                
                            </span>
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