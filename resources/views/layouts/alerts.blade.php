<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <div class="alert alert-{{$msg}}">{{Session::get('alert-'.$msg) }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                @if (Session::has('errores'))
                    <hr>
                    <ul>    
                    @foreach (Session::get('errores') as $err_arr)
                        <li><b>{{ $err_arr[0] }} :</b> {{ $err_arr[1] }}</li>
                    @endforeach
                    </ul>
                @endif
            </div>
        @endif
    @endforeach
</div>