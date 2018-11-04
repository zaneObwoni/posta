@extends('layouts.dash')

@section('css')
<script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    
@stop

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            
            <!--mini statistics start-->
            <div class="row">



                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <a href="/admin/reports/stamps/2016-06-01/2030-12-31" title="Click for more details">
                            <span class="mini-stat-icon orange">
                            <i class="fa fa-gavel"></i></span>
                            <div class="mini-stat-info">
                                <span>{!! $letters !!}</span> Number of Estamps Sold
                            </div>
                        </a>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                    <a href="/admin/reports/riders/2016-06-01/2018-12-31" title="Click for more details">
                        <span class="mini-stat-icon tar">
                        <i class="fa fa-tag"></i></span>
                        <div class="mini-stat-info">
                            <span>{!! $drivers !!}</span> Number of Riders Recruited
                        </div>
                    </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <a href="/admin/reports/staff/2016-06-01/2030-12-31" title="Click for more details">
                            <span class="mini-stat-icon pink">
                                <i class="fa fa-money"></i>
                            </span>
                            <div class="mini-stat-info">
                                <span>{!! $staff !!}</span> Number of Staff Registered
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <a href="/admin/reports/emails/2016-06-01/2030-12-31" title="Click for more details">
                            <span class="mini-stat-icon pink">
                            <i class="fa fa-money"></i></span>
                            <div class="mini-stat-info">
                                <span>{!! $total_emails !!}</span> Number of Emails Sent
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <a href="/admin/reports/individuals/2016-06-01/2030-12-31" title="Click for more details">
                            <span class="mini-stat-icon green">
                            <i class="fa fa-eye"></i></span>
                            <div class="mini-stat-info">
                                <span>{!! $normalRentors !!}</span> Number of Individual Boxes Rented
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <a href="/admin/reports/corporates/2016-06-01/2030-12-31" title="Click for more details">
                            <span class="mini-stat-icon green">
                                <i class="fa fa-eye"></i>
                            </span>
                            <div class="mini-stat-info">
                                <span>{!! $corporatesRentors !!}</span> Number of Corporate Boxes Rented
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <a href="/admin/reports/stamps/2016-06-01/2030-12-31" title="Click for more details">
                            <span class="mini-stat-icon green">
                            <i class="fa fa-eye"></i></span>
                            <div class="mini-stat-info">
                                <span>KES. {!! $estamps_sum !!}</span>
                                <div>
                                    <h5>
                                        <b>
                                            Revenue from Estamps Sold
                                        </b>                                    
                                    </h5>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <a href="/admin/reports/boxes/2016-06-01/2030-12-31" title="Click for more details">
                            <span class="mini-stat-icon green">
                            <i class="fa fa-eye"></i></span>
                            <div class="mini-stat-info">
                                <span>KES. {!! $accounts_sum !!}</span> 
                                <div>
                                    <h5>
                                        <b>
                                            Revenue from Boxes Allocated 
                                        </b>                                    
                                    </h5>
                                </div>
                                
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <span class="mini-stat-icon green">
                            <i class="fa fa-eye"></i>
                        </span>
                        <div class="mini-stat-info">
                            <span style="margin-top:3%">
                                <a href="{!! route('boxes.index') !!}">
                                    Allocated and Unallocated Boxes
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
                                    Estamps handled by Agent
                                </a>                                
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <a href="/admin/reports/deliveries/2016-06-01/2018-12-31" title="Click for more details">
                            <span class="mini-stat-icon orange">
                            <i class="fa fa-gavel"></i></span>
                            <div class="mini-stat-info">
                                <span>Deliveries</span>
                            </div>
                        </a>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <a href="/admin/reports/pickings/2016-06-01/2018-12-31" title="Click for more details">
                            <span class="mini-stat-icon orange">
                            <i class="fa fa-gavel"></i></span>
                            <div class="mini-stat-info">
                                <span>Pickings</span>
                            </div>
                        </a>
                    </div>

                </div>
            </div>

            <!-- Include Required Prerequisites -->
            <!-- <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script> -->
            <!-- <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script> -->
            <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
            <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
            <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
            <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />

            <!-- Include Date Range Picker -->
            <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
            <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

            <!-- <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                <span></span> <b class="caret"></b>
            </div> -->

            

            <script type="text/javascript">
      
                $(function() {

                    var start = moment().subtract(90, 'days');
                    var end = moment();

                    function cb(start, end) {
                        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                        window.location.href = "/admin/dashboard/"+start.format('YYYY-MM-DD')+"/"+end.format('YYYY-MM-DD')+"";
                    }

                    $('#reportrange').daterangepicker({
                        startDate: start,
                        endDate: end,
                        ranges: {
                           // 'Today': [moment(), moment()],
                           // 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                           // 'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                           // 'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                           // 'This Month': [moment().startOf('month'), moment().endOf('month')],
                           // 'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        }
                    }, cb);

                    // cb(start, end);
                    
                });
            </script>
            <!--mini statistics end-->

        </section>
    </section>
    <!--main content end-->
    

@stop

@section('js')
    {{--Disabled by Dan for js load--}}
    @include('includes.js')
    
@stop