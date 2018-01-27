<?php $customerOrders = Auth::user()->getCustomerNewOrders(); ?>
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
                            @if($customerOrders->count() > 0)
                                <span class="notification">{{$customerOrders->count()}}</span>
                            @endif
                        <p class="hidden-lg hidden-md">Notifications</p>
                    </a>

                    <ul class="dropdown-menu">
                        @if($customerOrders->count() > 1)
                            <li class="red">Имате {{$customerOrders->count()}} нови поръчки</li>
                        @elseif($customerOrders->count() == 1)
                            <li class="red">Имате {{$customerOrders->count()}} нова поръчка</li>
                        @endif
                        @if($customerOrders->count() > 0)
                            @foreach($customerOrders->get() as $order)
                                <li><a data-order="{{$order->id}}"  href="/manager/edit-order/{{$order->id}}">{{$order->services->name}} - {{$order->customer->fullName}}</a></li>
                            @endforeach
                            <li><a href="{{route('manager')}}">Натисни тук за повече</a></li>
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
{{--<script>--}}
    {{--var $dOut = $('#date'),--}}
        {{--$hOut = $('#hours'),--}}
        {{--$mOut = $('#minutes'),--}}
        {{--$sOut = $('#seconds'),--}}
        {{--$ampmOut = $('#ampm');--}}
    {{--var months = [--}}
        {{--'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'--}}
    {{--];--}}

    {{--var days = [--}}
        {{--'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'--}}
    {{--];--}}

    {{--function update(){--}}
        {{--var date = new Date();--}}

        {{--var ampm = date.getHours() < 12--}}
            {{--? 'AM'--}}
            {{--: 'PM';--}}

        {{--var hours = date.getHours() == 0--}}
            {{--? 12--}}
            {{--: date.getHours() > 12--}}
                {{--? date.getHours() - 12--}}
                {{--: date.getHours();--}}

        {{--var minutes = date.getMinutes() < 10--}}
            {{--? '0' + date.getMinutes()--}}
            {{--: date.getMinutes();--}}

        {{--var seconds = date.getSeconds() < 10--}}
            {{--? '0' + date.getSeconds()--}}
            {{--: date.getSeconds();--}}

        {{--var dayOfWeek = days[date.getDay()];--}}
        {{--var month = months[date.getMonth()];--}}
        {{--var day = date.getDate();--}}
        {{--var year = date.getFullYear();--}}

        {{--var dateString = dayOfWeek + ', ' + month + ' ' + day + ', ' + year;--}}

        {{--$dOut.text(dateString);--}}
        {{--$hOut.text(hours);--}}
        {{--$mOut.text(minutes);--}}
        {{--$sOut.text(seconds);--}}
        {{--$ampmOut.text(ampm);--}}
    {{--}--}}

    {{--update();--}}
    {{--window.setInterval(update, 1000);--}}
{{--</script>--}}

{{--<script>--}}
    {{--var clock = new Vue({--}}
        {{--el: '#clock',--}}
        {{--data: {--}}
            {{--time: '',--}}
            {{--date: ''--}}
        {{--}--}}
    {{--});--}}

    {{--var week = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];--}}
    {{--var timerID = setInterval(updateTime, 1000);--}}
    {{--updateTime();--}}
    {{--function updateTime() {--}}
        {{--var cd = new Date();--}}
        {{--clock.time = zeroPadding(cd.getHours(), 2) + ':' + zeroPadding(cd.getMinutes(), 2) + ':' + zeroPadding(cd.getSeconds(), 2);--}}
        {{--clock.date = zeroPadding(cd.getFullYear(), 4) + '-' + zeroPadding(cd.getMonth()+1, 2) + '-' + zeroPadding(cd.getDate(), 2) + ' ' + week[cd.getDay()];--}}
    {{--};--}}

    {{--function zeroPadding(num, digit) {--}}
        {{--var zero = '';--}}
        {{--for(var i = 0; i < digit; i++) {--}}
            {{--zero += '0';--}}
        {{--}--}}
        {{--return (zero + num).slice(-digit);--}}
    {{--}--}}
{{--</script>--}}

{{--<script>--}}
    {{--$(document).ready(function(){--}}
        {{--$moving_tab = $('<div class="moving-tab"/>');--}}
        {{--$('.sidebar .nav-container').append($moving_tab);--}}

        {{--$this = $('.sidebar .nav').find('li.active a');--}}
        {{--animationSidebar($this, false);--}}
        {{--$('div').removeClass('.moving-tab');--}}
        {{--if (window.history && window.history.pushState) {--}}

            {{--// console.log('sunt in window.history');--}}
            {{--$(window).on('popstate', function() {--}}

                {{--// console.log('am apasat pe back, locatia noua: ', window.location.pathname);--}}

                {{--setTimeout(function(){--}}
                    {{--// console.log('incep animatia cu 1ms delay');--}}
                    {{--$this = $('.sidebar .nav').find('li.active a');--}}
                    {{--animationSidebar($this,true);--}}
                {{--},1);--}}

            {{--});--}}

        {{--}--}}
    {{--});--}}
    {{--$(window).resize(function(){--}}
        {{--$this = $('.sidebar .nav').find('li.active a');--}}
        {{--animationSidebar($this,true);--}}

    {{--});--}}
    {{--$('.sidebar .nav > li > a').click(function(){--}}
        {{--$this = $(this);--}}
        {{--animationSidebar($this, true);--}}
    {{--});--}}

    {{--function animationSidebar($this, animate){--}}
        {{--// console.log('incep animatia si butonul pe care sunt acum este:', $this[0].href );--}}
        {{--if(!$this.parent('li').position())--}}
            {{--return;--}}

        {{--$current_li_distance = $this.parent('li').position().top - 10;--}}

        {{--button_text = $this.html();--}}

        {{--$(".moving-tab").css("width", 230 + "px");--}}

        {{--if(animate){--}}
            {{--$('.moving-tab').css({--}}
                {{--'transform':'translate3d(0,' + $current_li_distance + 'px, 0)',--}}
                {{--'transition': 'all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1)'--}}
            {{--});--}}
        {{--}else{--}}
            {{--$('.moving-tab').css({--}}
                {{--'transform':'translate3d(0,' + $current_li_distance + 'px, 0)'--}}
            {{--});--}}
        {{--}--}}

        {{--setTimeout(function(){--}}
            {{--$('.moving-tab').html(button_text);--}}
        {{--}, 100);--}}
    {{--}--}}
{{--</script>--}}