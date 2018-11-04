<div class="col-sm-3">
    <section class="panel">
        <div class="panel-body">
            <a href="{!! route('emails.create') !!}"  class="btn btn-compose">
                Compose Mail
            </a>
            <ul class="nav nav-pills nav-stacked mail-nav">
                <li class="active"><a href="{!! route('emails.index') !!}"> <i class="fa fa-inbox"></i> Inbox  <span class="label label-danger pull-right inbox-notification">{!! $notifications_emails !!}</span></a></li>
                <li><a href="{!! route('emails.outbox') !!}"> <i class="fa fa-envelope-o"></i> Sent Mail</a></li>
                <li>
                    <a href="#"> 
                        <i class="fa fa-file-text-o"></i> 
                        Archive Mail
                    </a>
                </li>
            </ul>
        </div>
    </section>                  
</div>