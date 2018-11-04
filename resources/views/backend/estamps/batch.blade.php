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
                           
                            <!--widget start-->
                            <aside class="profile-nav alt">
                                <section class="panel">
                                    <div style="padding: 2px 0 0 5%;">                                                
                                        <p>
                                            <h2 style="color:#000;">
                                                Your Bulk Letters
                                            </h2>
                                        </p>
                                    </div>

                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Receiver Name</th>
                                                    <th>Box</th>                                                  
                                                    <th>Town</th>
                                                    <th>Recipient Phone</th>
                                                    <th>Price</th>
                                                    <th>Remove</th>
                                                </tr>
                                            </thead>
                        
                                            <tbody>
                                                
                                                    @if($estamps->count())
                                                        @foreach($estamps as $estamp)
                                                        <tr>
                                                            <td>{!! $estamp->recipient_name !!}</td>
                                                            <td>{!! $estamp->destination_box !!}-{!! $estamp->destination_code !!}</td>
                                                            <td>{!! $estamp->destination_town !!}</td>
                                                            <td>{!! $estamp->recipient_phone !!}</td>
                                                            <td>{!! $estamp->price !!}</td>
                                                            <td>
                                                            {!! Form::open(['url' => route('estamps.delete', $estamp->id), 'class' => 'form-horizontal'] ) !!}
                                                                {!! Form::hidden('id', $estamp->id) !!}
                                                                {!! Form::submit('X', ['class' => 'btn btn-danger']) !!}
                                                            {!! Form::close() !!}

                                                            {{--{{ Form::open(['method' => 'DELETE', 'route' => 'estamps.delete', $estamp->id]) }}
                                                                {{ Form::hidden('id', $estamp->id) }}
                                                                {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                                                            {{ Form::close() }}--}}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    @endif
                                                    
                                            </tbody>
                                        </table>
                                        <div style="">
                                            <div>
                                                
                                            </div>
                                            <div class="pull-right" style="font-size:20px;">
                                                Total: KShs: {!! $totalPrice !!}
                                            </div>
                                        </div>
                                </section>
                            </aside>
                            <!--widget end-->

                            <div>
                            @if(Auth::User()->isCorporate())
                                <div>
                                    <a href="{!! route('bulk.payment.make', $totalPrice) !!}">
                                        <button>
                                            <h4>
                                                Cash Customer Pay Now
                                            </h4>
                                        </button>
                                    </a>
                                </div>
                                <br>
                                <?php $uniqueNumber = rand(111111,999999); ?>
                                <div>
                                    <a href="{!! route('advance.customer.proceed', [$totalPrice, $uniqueNumber]) !!}/?unique_number={!! $uniqueNumber !!}">
                                        <button>
                                            <h4>
                                                Advance Payment Customer. Click Here!
                                            </h4>
                                        </button>
                                    </a>
                                </div>
                                <br>
                                <div>
                                    <a href="{!! route('account.customer.proceed', [$totalPrice, $uniqueNumber]) !!}/?unique_number={!! $uniqueNumber !!}">
                                        <button>
                                            <h4>
                                                Account Customer. Click Here!
                                            </h4>
                                        </button>
                                    </a>
                                </div>
                            @else
                                <a href="{!! route('bulk.payment.make', $totalPrice) !!}">
                                    <button>
                                        <h4>
                                            Please Pay for your Bulk Mail
                                        </h4>
                                    </button>
                                </a>
                            @endif
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
	
			