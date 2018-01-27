<div class="sidebar" data-color="purple" data-image="{{url('/img/sidebar-1.jpg')}}">
    <div class="logo">
        <a href="{{ route('admin') }}" class="simple-text">
            Администратор
        </a>
    </div>
    <div class="sidebar-wrapper" data-color="purple" >
        <ul class="nav">

            <li>
                <a href="{{route('admin')}}" >
                    {{Auth::user()->firstName}}
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="material-icons">person</i>
                    <p class="active">Потребители</p>
                </a>
                <ul class="dropdown-menu" data-color="purple" >
                    <li><a href="{{ route('users') }}">Всички потребители</a></li>
                    <li><a href="{{ route('create-user') }}">Добавяне на потребител</a></li>
                </ul>
            </li>
			<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<i class="material-icons">sort</i>
                    <p class="active">Услуги</p>
                </a>
                <ul class="dropdown-menu" data-color="purple" >
                    <li><a href="{{ route('show-services') }}">Всички услуги</a></li>
                    <li><a href="{{ route('create-service') }}">Добавяне на услуга</a></li>
                </ul>
            </li>
            <li>

                <a href="{{route('manager')}}" >
                    <i class="material-icons">forward</i>
                    Мениджър панел
                </a>

                <a href="{{route('customer')}}" >
                    <i class="material-icons">forward</i>
                    Клиент панел
                </a>

                <a href="{{route('driver')}}" >
                    <i class="material-icons">forward</i>
                    Шофьор панел
                </a>
            </li>
        </ul>
    </div>
</div>