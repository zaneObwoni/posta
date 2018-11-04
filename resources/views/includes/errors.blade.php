@if (isset($errors) && $errors->any())
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-danger alert-alt">
                <strong><i class="fa fa-exclamation-circle"></i> Error</strong><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <br/>
@endif