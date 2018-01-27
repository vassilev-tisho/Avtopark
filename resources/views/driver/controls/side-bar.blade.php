<div class="sidebar" data-color="purple" data-image="{{url('/img/sidebar-1.jpg')}}">
    <div class="logo">
        <a href="{{ route('driver') }}" class="simple-text">
            Шофьор
        </a>
    </div>
    <div class="sidebar-wrapper" data-color="purple" >
        <ul class="nav">
            <li>
                <a href="{{route('driver')}}" >
                    {{ Auth::user()->fullName }}
                </a>
            </li>
            <li class="dropdown">

            @if(Auth::user()->hasRole('ADMIN'))
                <li>
                    <a href="{{route('admin')}}" >
                        <i class="material-icons">reply</i>
                        Admin panel
                    </a>
                </li>
			@endif

        </ul>
    </div>
</div>