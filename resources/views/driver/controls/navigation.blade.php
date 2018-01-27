<?php $driverOrders = Auth::user()->getDriverNewOrders(); ?>
<div class="navbar navbar-transparent navbar-absolute">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="material-icons">notifications</i>
                        @if($driverOrders->count() > 0)
                            <span class="notification">{{$driverOrders->count()}}</span>
                        @endif
                        <p class="hidden-lg hidden-md">Notifications</p>
                    </a>

                    <ul class="dropdown-menu">
                        @if($driverOrders->count() > 1)
                            <li class="red">Имате {{$driverOrders->count()}} нови поръчки</li>
                        @elseif($driverOrders->count() == 1)
                            <li class="red">Имате {{$driverOrders->count()}} нова поръчка</li>
                        @endif
                        @if($driverOrders->count() > 0)
                            @foreach($driverOrders->get() as $order)
                                <li><a href="{{route('driver')}}">{{$order->services->name}}</a></li>
                            @endforeach
                            {{--<li><a href="{{route('driver')}}">For more  click here</a></li>--}}
                        @endif
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="material-icons">person</i>
                        <p class="hidden-lg hidden-md">Profile</p>
                        {{Auth::user()->firstName}}
                    </a>
                    <ul class="dropdown-menu">
                        <li><i class="material-icons">person</i></li>
                        <li><a href="#">Profile</a></li>
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>