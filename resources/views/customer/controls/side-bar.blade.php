<div class="sidebar" data-color="purple" data-image="{{url('/img/sidebar-1.jpg')}}">
    <div class="logo">
        <a href="{{ route('customer') }}" class="simple-text">
            Kлиент
        </a>
    </div>
    <div class="sidebar-wrapper" data-color="purple" >
        <ul class="nav">
            <li>
                <a href="{{route('customer')}}" >
                    {{Auth::user()->fullName}}
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
            </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="material-icons">shopping_cart</i>
                        <p class="active">Поръчки</p>
                    </a>

                    <ul class="dropdown-menu" data-color="purple" >
                        <li><a href="{{ route('create-customer-order') }}">Нова поръчка</a></li>
                        <li><a href="{{ route('customer-orders') }}">Моите поръчки</a></li>
                    </ul>
                </li>
        </ul>
    </div>
</div>