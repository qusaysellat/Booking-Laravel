<section id="footer">
    <div class="container-fluid">
        <center style="color:#fff;">
            <div class="container-fluid">
                <div class="well well-sm main-footer" style="background-color:#222; border:0px">
                    @if(Auth::user())
                        <div class="contactus">
                            <div class="row">
                                <form action="{{route('makecontactus')}}" method="post"
                                      role="form">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="subject">{{trans('admin.contactus')}}</label>
                                            <input class="form-control" type="text" name="subject" id="subject" required
                                                   value='{{ Request::old('subject') }}' placeholder={{trans('admin.subject')}}>
                                        </div>
                                        <input type="hidden" name="_token" value= {{ Session::token() }} >

                                        <div class="form-group">
                                                <textarea class="form-control" rows="3" name="content" required
                                                          id="content"
                                                          placeholder={{trans('admin.content')}}>{{ Request::old('content') }}</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <button class="btn btn-success btn-block" type="submit">{{trans('admin.send')}}
                                                </button>
                                            </div>
                                            <div class="col-md-offset-2 col-md-5"><a
                                                        href="{{route('newcontactus')}}">
                                                    <button type="button" class="btn btn-info btn-block"> {{trans('admin.see_old')}}
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="col-sm-6">
                                    <div class="container-fluid">
                                        <p class="text-center">{{trans('admin.findus')}}</p>
                                    <div class="row">
                                        <div class="col-xs-4"><a href="#"> <i class="fa fa-google-plus fa-5x"></i></a></div>
                                        <div class="col-xs-4"><a href="#"> <i class="fa fa-facebook fa-5x"></i></a></div>
                                        <div class="col-xs-4"><a href="#"> <i class="fa fa-youtube fa-5x"></i></a></div>
                                    </div>
                                        <br/>
                                    <div class="row">
                                        <div class="col-xs-4"><a href="#"> <i class="fa fa-twitter fa-5x"></i></a></div>
                                        <div class="col-xs-4"><a href="#"> <i class="fa fa-pinterest fa-5x"></i></a></div>
                                        <div class="col-xs-4"><a href="#"> <i class="fa fa-linkedin fa-5x"></i></a></div>
                                        <br/>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>

                        @else
                        <div class="container-fluid">
                        <p class="lead">{{trans('admin.findus')}}</p>
                        <div class="row">
                            <div class="col-xs-4 col-sm-2"><a href="#"> <i class="fa fa-google-plus fa-5x"></i></a></div>
                            <div class="col-xs-4 col-sm-2"><a href="#"> <i class="fa fa-facebook fa-5x"></i></a></div>
                            <div class="col-xs-4 col-sm-2"><a href="#"> <i class="fa fa-youtube fa-5x"></i></a></div>
                            <div class="col-xs-4 col-sm-2"><a href="#"> <i class="fa fa-twitter fa-5x"></i></a></div>
                            <div class="col-xs-4 col-sm-2"><a href="#"> <i class="fa fa-pinterest fa-5x"></i></a></div>
                            <div class="col-xs-4 col-sm-2"><a href="#"> <i class="fa fa-linkedin fa-5x"></i></a></div>
                            <br/>
                        </div>
                        </div>
                    @endif

                    <div class="row">
                        <br/>
                        <p class="lead" class="title-footer">
                            {{trans('admin.reserved')}} &copy; <?php echo date("Y");?>
                        </p>
                    </div><!--end .row-->

                </div><!--end .well .well-sm .main-footer-->
            </div><!--end .container-->
        </center>
    </div><!--end .container-->
</section><!--