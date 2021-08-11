@if($results)
    <table class="table table-condensed table-striped table-responsive">
        @foreach($results as $result)
            <tr class="success">
                <td><a href="{{route('getuser',['username'=>$result->username])}}">{{$result->username}}</a></td>
            </tr>
        @endforeach
    </table>
@endif