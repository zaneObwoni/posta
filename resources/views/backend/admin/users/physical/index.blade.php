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
                                    
                                    <h2>Physical Boxes Users Table</h2>
                                    
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>PO Box</th>
                                                <th>Verify User</th>
                                            </tr>
                                        </thead>
                    
                                        <tbody>
                                            
                                                @if($users->count())
                                                    @foreach($users as $user)
                                                    <tr>
                                                        <td>{!! $user->first_name !!}</td>
                                                        <td>{!! $user->last_name !!}</td>
                                                        <td>{!! $user->email !!}</td>
                                                        <td>{!! $user->phone !!}</td>
                                                        <td>{!! $user->postbox_id !!}-{!! $user->postcode_id !!}</td>
                                                        @if($user->code==1111)
                                                        <td>
                                                            <a href="{!! route('admin.user.activate', $user->id) !!}">Verify</a>
                                                        </td>
                                                        @else
                                                            User Verified
                                                        @endif
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
	
			