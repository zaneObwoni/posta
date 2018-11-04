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
                                    
                                    <div class="pull-right">                                    
                                        <button type="button" class="btn btn-success">
                                            <a href="{!! route('admin.createstaff') !!}">
                                                <span>Create New Staff</span>
                                            </a>
                                        </button>
                                    </div>

                                    <h2>All Staff</h2>

                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>

                                        <tr>
                                            <th>Name</th>

                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        @if($users->count())
                                            @foreach($users as $user)
                                                <tr>
                                                    <td>{!! $user->first_name.' '.$user->last_name  !!}</td>

                                                    <td>{!! $user->email !!}</td>
                                                    <td>{!! $user->phone !!}</td>
                                                    <td>
                                                        <a href="{!! route('admin.staff.edit', $user->id) !!}">
                                                            <img src="/edit.png" alt="edit" width="25" height="20" title="Edit User">
                                                        </a> 
                                                        <!-- |  
                                                        <a href="">
                                                            <img src="/delete.png" alt="deactivate" width="25" height="20" title="Deactivate User">
                                                        </a> -->
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @endif
<!-- Hi-->
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
	
			