@extends('layouts.dash')

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div id="job-history" class="tab-pane ">
                    <div class="col-md-12">
                    	<div style="margin-left:-3%">
                    		<div class="row">
                                
                                <h2>Admin Notifications</h2>
                                
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Content</th>
                                            <th>Sender Phone</th>
                                            <th>Recipient Phone</th>                                                      
                                        </tr>
                                    </thead>
                
                                    <tbody>
                                        
                                        @if($notifications->count())
                                            @foreach($notifications as $notification)
                                            <tr>
                                                <td>{!! $notification->title !!}</td>
                                                <td>{!! $notification->content !!}</td>
                                                <td>{!! $notification->sender_phone !!}</td>
                                                <td>{!! $notification->recipient_phone !!}</td> 
                                            </tr>
                                            @endforeach
                                        @endif
                                        
                                        <!-- @if($notifications->count())
                                            @foreach($notifications as $notification)
                                            <tr class="unread">
                                                <td class="inbox-small-cells">
                                                    <input type="checkbox" class="mail-checkbox">
                                                </td>
                                                <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                                <td class="view-message  dont-show"><a href="{!! route('notifications.show', $notification->id) !!}">{!! $notification->title !!}</a></td>
                                                <td class="view-message "><a href="">{!! getExcerpt($notification->content, 20) !!}</a></td>
                                                <td class="view-message  text-right">{!! $notification->created_at !!}</td>
                                            </tr>
                                            @endforeach
                                        @endif -->
                                    </tbody>
                                </table>

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
	
			