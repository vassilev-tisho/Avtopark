@extends('manager.manager')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">Създаване на поръчка</h4>
                            <p class="category">Форма за създаване на нова поръчка</p>
                        </div>
                        <div class="card-content">
                            <form method="POST">
                                {{ csrf_field() }}

                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating {{$errors->has('vehicle') ? 'has-error' : ''}}">
                                            <select class="selectpicker" data-style="btn btn-primary btn-round" title="Налични превозни средства" data-size="{{count($vehicles) + 1}}" name="vehicle" id="vehicles">
                                                <option value="">--Без избор--</option>

                                                @foreach($freeVehicles as $result)
                                                    <option  value="{{ $result->id }}" data-maxweight="{{$result->chargeWeight}}" data-driveLicenseNeeded="{{$result->driveLicenseNeed}}">
                                                        {{ $result->brand }} - Рег.Номер {{ $result->regNumber }} : {{$result->chargeWeight}}
                                                    </option>
                                                @endforeach

                                            </select>
                                            @if($errors->has('vehicle'))
                                                <span class="danger" style="margin-top: 7px;">
                                                        {{$errors->first('vehicle')}}
                                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating {{$errors->has('driver') ? 'has-error' : ''}}" >
                                            <select class="selectpicker" data-style="btn btn-primary btn-round" title="Избор на Шофьор" data-size="{{count($drivers) + 1}}" name="driver" id="drivers">
                                                <option value="">--Без избор--</option>
                                                @foreach($drivers as $driver)
                                                    <option value="{{$driver->id}}" data-driverid="{{$driver->id}}" data-driverdrivelicense="{{$driver->driveLicenseCategory}}"> {{$driver->fullName}} - Kатегория : {{$driver->driveLicenseCategory}}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('driver'))
                                                <span class="danger">
                                                    {{$errors->first('driver')}}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating">

                                            <label for="customer">Клиент</label>
                                            <input type="text"  class="form-control" name="customer" id="customer" value="{{$customer->fullName}}" disabled>

                                        </div>
                                    </div>
                                </div>
                                    <div class="col-lg-12">
                                        <div id="map-holder"></div>
                                        <div id="text-holder"></div>
                                    </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group label-floating {{$errors->has('addressSending') ? 'has-error' : ''}}" >
                                            <label for="addressSending">Адрес на изпращане</label>
                                            <input type="text"  class="form-control" name="addressSending" id="addressSending" required>

                                            @if($errors->has('addressSending'))
                                                <span class="danger">
											{{$errors->first('addressSending')}}
										</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating {{$errors->has('addressReceiver') ? 'has-error' : ''}}" >
                                            <label   for="addressReceiver">Адрес на получаване</label>
                                            <input type="text" class="form-control" name="addressReceiver" id="addressReceiver" required>

                                            @if($errors->has('addressReceiver'))
                                                <span class="danger">
											{{$errors->first('addressReceiver')}}
										</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating {{$errors->has('kilometres') ? 'has-error' : ''}}" >
                                            <label for="kilometres">Разстояние в километри</label>
                                            <input type="text" class="form-control" name="kilometres" id="kilometres" value="{{old('kilometres')}}">

                                            @if($errors->has('kilometres'))
                                                <span class="danger">
											        {{$errors->first('kilometres')}}
										        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating {{$errors->has('timeToArrive') ? 'has-error' : ''}}" >

                                            <label for="time" > Време в минути</label>
                                            <input class="form-control" name="time" id="time"  value="{{old('time')}}">

                                            @if($errors->has('timeToArrive'))
                                                <span class="danger">
										        	{{$errors->first('timeToArrive')}}
										        </span>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group label-floating {{$errors->has('price') ? 'has-error' : ''}}" >
                                            <label for="price">Цена</label>
                                            <input type="number" step="0.01" class="form-control" name="price" id="price"  >
                                            {{--<script>--}}
                                            {{--var price = $('#price').data("$orderPrice");--}}
                                            {{--console.log(price);--}}
                                            {{--</script>--}}
                                            @if($errors->has('price'))
                                                <span class="danger">
										        	{{$errors->first('price')}}
										        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating {{$errors->has('manager_id') ? 'has-error' : ''}}" >
                                            <input type="hidden" class="form-control" name="manager" id="manager_id" value="{{Auth::user()->id}}">

                                            @if($errors->has('manager_id'))
                                                <span class="danger">
										        	{{$errors->first('manager_id')}}
										        </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">Създай поръчка</button>
                            </form>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')

    <script>
        //services
        $('#services').on('change', function(){
            var selected = $(this).find('option:selected');

            var minWeight = selected.data('minweight');
            var maxWeight = selected.data('maxweight');

            var optionIndexes = [];

            $('#vehicles option').hide();

            $('.dropdown-toggle[data-id="vehicles"]').next('.dropdown-menu').find('li').hide();

            $('#vehicles option').each(function(k, i){

                var vehicleMaxWeight = $(this).data('maxweight');

                if(vehicleMaxWeight >= minWeight && vehicleMaxWeight <= maxWeight){
                    $(this).show();
                    optionIndexes.push(k);
                }
            });

            optionIndexes.forEach(function(entry) {
                $('.dropdown-toggle[data-id="vehicles"]').next('.dropdown-menu').find('li:nth-child('+entry+')').show();
            });
        });


        $('#vehicles').on('change', function () {
            var selected = $(this).find('option:selected');
            var driveLicenseNeeded = selected.data('drivelicenseneeded');
            var optionIndexes = [];
            var driversOnRoad = [];
            var freeDrivers   = [];

            $('#drivers option').hide();
            $('.dropdown-toggle[data-id="drivers"]').next('.dropdown-menu').find('li').hide();

            $('#drivers option').each(function(k, i){
                var driverLicenseCategory = $(this).data('driverdrivelicense');
                var vehicleLicenseNeeded = $(this).data('driveLicenseNeeded');

                if(driverLicenseCategory == driveLicenseNeeded){
                    $(this).show();
                    optionIndexes.push(k);
                }


                $('#drivers option').each(function (k) {
                    var driverId = $(this).data('driverid');
                    if(driverId > 0){
                        $(this).hide();
                        driversOnRoad.push(k);
                    }
                })


            });
            driversOnRoad.forEach(function(entry) {
                $('.dropdown-toggle[data-id="drivers"]').next('.dropdown-menu').find('li:nth-child('+entry+')').hide();
            });

            optionIndexes.forEach(function(entry) {
                $('.dropdown-toggle[data-id="drivers"]').next('.dropdown-menu').find('li:nth-child('+entry+')').show();
            });
        });
        //vehicles

    </script>
    <script>
        //vehicles

        //drivers
    </script>
    <script type='text/javascript'>

    </script>

    <script type='text/javascript'>
        var onMapLoad = function () {
            var textHolderDomEl = document.getElementById('text-holder'),
                addressInputA   = document.getElementById('addressSending'),
                addressInputB   = document.getElementById('addressReceiver'),
                distanceInput   = document.getElementById('kilometres'),
                time            = document.getElementById('time'),
                price           = document.getElementById('price'),

                route = new routeControl({
                    mapDomEl: document.getElementById('map-holder'),
                    center: {
                        lat: 42.8489128, // Gabrovo, Bulgaria
                        lng: 25.255236
                    },
                    onRouteSuccess: function (routeData) {
                        var priceKm         = $('select#services option:selected').data('priceperkilometer');
                        addressInputA.value = routeData.addressA || "";
                        addressInputB.value = routeData.addressB || "";
                        distanceInput.value = parseInt(routeData.distanceInMeters.value / 1000, 10); // in km
                        time.value          = parseInt(routeData.timeInSeconds.value / 60, 10); // time in mins
                        price.value         = parseInt(routeData.distanceInMeters.value / 1000, 10) * priceKm;
                        textHolderDomEl.innerHTML = "";
                    },
                    onRouteFail: function () {
                        var html = [
                            "<p class='error'>Cannot calculate route.</p>",
                            "<p class='error'>Please select another points.</p>"
                        ].join('');

                        addressInputA.value = "";
                        addressInputB.value = "";
                        distanceInput.value = "";
                        textHolderDomEl.innerHTML = html;
                    }
                });

            var onAddressChange = function (pointIndex, event) {
                route.setAddress(event.target.value, pointIndex);
            }

            addressInputA.addEventListener('blur', onAddressChange.bind(null, route.pointIndexes.A));
            addressInputB.addEventListener('blur', onAddressChange.bind(null, route.pointIndexes.B));
        }
    </script>
    <style>
        #map-holder {
            height: 320px;
            /*width: 400px;*/
        }
    </style>
    <script type="text/javascript" src="{{ URL::asset('assets/js/routeControl.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?callback=onMapLoad&region=BG&key=AIzaSyDJ8-74q6kLtxWZ5egVzUwVzwSkKQiGvzQ"></script>
@endsection