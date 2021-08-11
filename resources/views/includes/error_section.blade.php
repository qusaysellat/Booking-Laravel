<div class="messages">
@if(count($errors) > 0)
    <div class="container-fluid">
        <div class="alert alert-danger">
            <ul class="list-unstyled">
                @foreach($errors-> all() as $key=>$error)
                    <li>{{{$error}}}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <?php $errors = array(); ?>
@endif
@if(Session::has('message'))
    <div class="container-fluid">
        <div class="alert alert-success">
            {{{ Session::get('message') }}}
        </div>
    </div>
    <?php
        Session::forget('message');
    ?>
@endif
    @if(Session::has('warning'))
        <div class="container-fluid">
            <div class="alert alert-warning">
                {{{ Session::get('warning') }}}
            </div>
        </div>
        <?php
        Session::forget('warning');
        ?>
    @endif
</div>