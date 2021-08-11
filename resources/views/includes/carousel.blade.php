<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php $i = 0; ?>
        @foreach($user->images as $image)
            <li data-target="#myCarousel"
                data-slide-to={{ $i }} <?php if ($i == 0) echo 'class="active"'; $i++; ?> ></li>
            @if(Auth::user()&& Auth::user()->id==$user->id)
                <a href="{{  route('deleteimage',['id'=> $image->id]) }}"> <i class="fa fa-trash"></i> </a>
                @endif
        @endforeach
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <?php $i=0; ?>
        @foreach($user->images as $image)
            <div class="item <?php if ($i == 0) echo 'active'; $i++; ?> ">
                <img src="{{  route('publicimage',['id'=> $image->id]) }}" alt="{{$image->name}}">
            </div>
        @endforeach
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
    </a>
</div>