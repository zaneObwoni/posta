@extends('layouts.dash')

@section('content')

    
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div id="job-history" class="tab-pane ">
   
                    @if(Session::has('message'))
                        <div class="success alert-danger">
                            <strong>Success!</strong><h3>{{ Session::get('message') }}</h3>
                        </div>
                    @endif

                </div>

                <a href="{!! route('admin.main.pickings.create') !!}" class="pull-right" style="margin-right:5%;">
                    <h3>
                        Back
                    </h3>                    
                </a>
            </div>
            <!--mini statistics end-->            
        </section>
    </section>
    <!--main content end-->    

@stop

@section('js')
    @include('includes.js')

    <script type="text/javascript">
        function printDiv(divName) {
             var printContents = document.getElementById(divName).innerHTML;
             var originalContents = document.body.innerHTML;

             document.body.innerHTML = printContents;

             window.print();

             document.body.innerHTML = originalContents;
        }
    </script>
@stop
	
			