@extends('layouts.dash')

@section('content')

        <!--main content start-->
<section id="main-content">
    <section class="wrapper">
        @if(Auth::User()->isPostMaster() || Auth::User()->isAdmin())
            <div class="row">
                <div class="col-md-6">
                    
                    <div class="mini-stat clearfix">
                        <div class="mini-stat-info">

                            <a href="{!! route('admin.createstaff') !!}">
                                <span title="click to add new staff">Add New Staff</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(Auth::User()->isAdmin())
            <div class="row">
                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <div class="mini-stat-info">
                            <a href="{!! route('admin.allstaffshow', 'id=2') !!}">
                                <span>PostMaster</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <div class="mini-stat-info">
                            <a href="{!! route('admin.allstaffshow', 'id=9') !!}">
                                <span>Philately</span>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
                    <!--mini user end-->


            <!--user rows-->
            <div class="row">
                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <div class="mini-stat-info">
                            <a href="{!! route('admin.allstaffshow', 'id=7') !!}">
                                <span>Clerks</span>

                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <div class="mini-stat-info">
                            <a href="{!! route('admin.allstaffshow', 'id=5') !!}">
                                <span>Agents</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--mini user end

             <!--user rows-->
            <div class="row">
                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <div class="mini-stat-info">
                            <a href="{!! route('admin.allstaffshow', 'id=6') !!}">
                                <span>Delivery and Picking staffs</span>

                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mini-stat clearfix">
                        <div class="mini-stat-info">
                            <a href="{!! route('admin.staffs') !!}">
                                <span>Driver/Rider</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>


    </section>
</section>
<!--main content end-->

<!--right sidebar end-->

@stop

@section('js')
    @include('includes.js')
@stop