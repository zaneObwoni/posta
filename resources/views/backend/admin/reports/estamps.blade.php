@extends('layouts.dash')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />

<script type="text/javascript" src="//code.jquery.com/jquery-1.12.3.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>

<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>

<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    message: 'Date here'
                },
                {
                    extend: 'csvHtml5',
                    message: 'Date here'
                },
                {
                    extend: 'excelHtml5',
                    message: 'Date here'
                }
//              'copyHtml5',
//              'excelHtml5',
//              'csvHtml5',
//              'pdfHtml5'
            ]

        } );
    } );
</script>


@section('content')

    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">

                <div>
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 60%">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                        <span></span> <b class="caret"></b>
                    </div>
                </div>

                <table id="example" class="display" cellspacing="0">
                    <thead>
                    <tr>

                        <th>Stamp Code</th>
                        <th>Receiver Name</th>
                        <th>To</th>
                        <th>Town</th>
                        <th>Recipient Phone</th>
                        <th>Price</th>
                    </tr>
                    </thead>

                    <tbody>

                    @if($estamps->count())
                        @foreach($estamps as $estamp)
                            <tr>
                                <td>{!! $estamp->code !!}</td>
                                <td>{!! $estamp->recipient_name !!}</td>
                                <td>{!! $estamp->destination_box !!}-{!! $estamp->destination_code !!}</td>
                                <td>{!! $estamp->destination_town !!}</td>
                                <td>{!! $estamp->recipient_phone !!}</td>
                                <td>{!! $estamp->price !!}</td>
   
                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                </table>
            </div>
        </section>
    </section>

</div>

@stop

<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />

<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />


<script type="text/javascript">

    $(function() {

        var start = moment().subtract(40, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            window.location.href = "/admin/reports/stamps/"+start.format('YYYY-MM-DD')+"/"+end.format('YYYY-MM-DD')+"";
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        // cb(start, end);

    });
</script>


