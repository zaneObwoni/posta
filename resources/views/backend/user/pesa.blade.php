@extends('layouts.dash')

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div class="col-md-3">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="top-stats-panel">
                                <div class="gauge-canvas">
                                    <h4 class="widget-h">Monthly
                                    Expense</h4>
                                    <canvas height="100" id="gauge" width=
                                    "160"></canvas>
                                </div>
                                <ul class="gauge-meta clearfix">
                                    <li class="pull-left gauge-value" id=
                                    "gauge-textfield"></li>
                                    <li class="pull-right gauge-title">
                                    Safe</li>
                                </ul>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-3">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="top-stats-panel">
                                <div class="daily-visit">
                                    <h4 class="widget-h">Daily
                                    Visitors</h4>
                                    <div id="daily-visit-chart" style=
                                    "width:100%; height: 100px; display: block">
                                    </div>
                                    <ul class="chart-meta clearfix">
                                        <li class=
                                        "pull-left visit-chart-value">
                                        3233</li>
                                        <li class=
                                        "pull-right visit-chart-title">
                                        <i class="fa fa-arrow-up"></i>
                                        15%</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-3">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="top-stats-panel">
                                <h4 class="widget-h">Posta</h4>
                                <div class="sm-pie"></div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-3">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="top-stats-panel">
                                <h4 class="widget-h">Package Destinations</h4>
                                <div class="bar-stats">
                                    <ul class="progress-stat-bar clearfix">
                                        <li data-percent="50%"><span class=
                                        "progress-stat-percent pink"></span></li>
                                        <li data-percent="90%"><span class=
                                        "progress-stat-percent"></span></li>
                                        <li data-percent="70%"><span class=
                                        "progress-stat-percent yellow-b"></span></li>
                                    </ul>
                                    <ul class="bar-legend">
                                        <li><span class="bar-legend-pointer pink"></span>
                                            Nairobi
                                        </li>
                                        <li>
                                            <span class="bar-legend-pointer green"></span>
                                            Kisumu
                                        </li>
                                        <li>
                                            <span class="bar-legend-pointer yellow-b"></span>
                                            Nakuru
                                        </li>
                                    </ul>
                                    <div class="daily-sales-info">
                                        <span class="sales-count">1200</span>
                                        <span class="sales-label">
                                            Packages delivered 
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
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