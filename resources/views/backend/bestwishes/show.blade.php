@extends('layouts.dash')

@section('content')


        <!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!--mini statistics start-->
        <div class="row">
            <div id="job-history" class="tab-pane ">
                <div class="row">
                    <div class="col-md-6" style="margin-left:5%;">
                        @if(is_numeric($id))
                                <!--widget start-->
                        <aside class="profile-nav alt">
                            <section class="panel">
                                <div style="padding: 2px 0 0 5%;">
                                    <p>
                                    <h3 style="color:#000;">
                                        Your Best Wish Stamp Details
                                    </h3>
                                    </p>
                                </div>

                                <ul class="nav nav-pills nav-stacked">
                                    <li><a> <i class="fa fa-tasks"></i> Sender Phone: <span
                                                    class="pull-right"><b>{!! $estamp->sender_phone !!}</b></span></a>
                                    </li>
                                    <li><a> <i class="fa fa-tasks"></i> Sender Name: <span
                                                    class="pull-right"><b>{!! $estamp->sender_name !!}</b></span></a>
                                    </li>
                                    <li><a> <i class="fa fa-tasks"></i> Destination Box : <span
                                                    class="pull-right"><b>{!! $estamp->recipient_box !!}</b></span></a>
                                    </li>
                                    <li><a> <i class="fa fa-tasks"></i> Destination Code : <span
                                                    class="pull-right"><b>{!! $estamp->recipient_code !!}</b></span></a>
                                    </li>
                                    <li><a> <i class="fa fa-tasks"></i> Destination Town : <span
                                                    class="pull-right"><b>{!! $estamp->recipient_town !!}</b></span></a>
                                    </li>
                                    <li><a> <i class="fa fa-tasks"></i> Recipient Name : <span
                                                    class="pull-right"><b>{!! $estamp->recipient_name !!}</b></span></a>
                                    </li>
                                    <li><a> <i class="fa fa-tasks"></i> Stamp Price : <span class="pull-right"><b
                                                        style="font-size:20px;">KShs: {!! $estamp->price!!}</b></span></a>
                                    </li>
                                </ul>

                            </section>
                        </aside>

                        <div>
                            <a href="/estamp/payment/make/{!! $estamp->price !!}/{!! $estamp->id !!}">
                                <button>
                                    <h4>
                                        Please Pay for your Bulk Bestwish E-Stamp
                                    </h4>
                                </button>
                            </a>
                        </div>

                        @else
                            <?php $price=0;$count=1;?>

                            <aside class="profile-nav alt">
                                <section class="panel">
                                    <div style="padding: 2px 0 0 5%;">
                                        <p>
                                        <h3 style="color:#000;">
                                            Your Best Wish Stamp Details
                                        </h3>
                                        </p>
                                    </div>

                                    <ul class="nav nav-pills nav-stacked">
                                        <li><a> <i class="fa fa-tasks"></i> Sender Phone: <span
                                                        class="pull-right"><b>{!! $user->phone !!}</b></span></a>
                                        </li>
                                        <li><a> <i class="fa fa-tasks"></i> Sender Name: <span
                                                        class="pull-right"><b>{!! $user->first_name.' '.$user->last_name !!}</b></span></a>
                                        </li>

                                        @foreach($estamp as $arr)

                                        {{--<li><a> <i class="fa fa-tasks"></i> Destination Box : <span--}}
                                                        {{--class="pull-right"><b>{!! $arr->recipient_box !!}</b></span></a>--}}
                                        {{--</li>--}}
                                        {{--<li><a> <i class="fa fa-tasks"></i> Destination Code : <span class="pull-right"><b>{!! $arr->recipient_code !!}</b></span></a>--}}
                                        {{--</li>--}}
                                        {{--<li><a> <i class="fa fa-tasks"></i> Destination Town : <span class="pull-right"><b>{!! $arr->recipient_town !!}</b></span></a>--}}
                                        {{--</li>--}}
                                        <li><a> <i class="fa fa-tasks"></i> Recipient {!! $count !!} : <span
                                                        class="pull-right"><b>{!! $arr->recipient_name !!}</b></span></a>
                                        </li>

                                        <?php $price=$price+ $arr->price; $count++?>
                                        @endforeach




                                        <li><a> <i class="fa fa-tasks"></i> Stamp Price : <span class="pull-right"><b
                                                            style="font-size:20px;">KShs: {!!$price!!}</b></span></a>
                                        </li>
                                    </ul>

                                </section>
                            </aside>


                            <div>
                                <!-- <a href="/estamp/payment/make/{!! $arr->price !!}/{!! $arr->code !!}"> -->
                                <a href="/bestwish/payment/make/10/{!! $arr->batch_number !!}">
                                    <button>
                                        <h4>
                                            Please Pay for your Bestwish E-Stamp
                                        </h4>
                                    </button>
                                </a>
                            </div>

                            @endif
                                    <!--widget end-->


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
	
			