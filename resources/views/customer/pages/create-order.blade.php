@extends('customer.customer')
@section('content')

        <div class="container-fluid"  >
            <div class="row">
                <div class="col-md-9">
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
                                        <div class="form-group label-floating {{$errors->has('services') ? 'has-error' : ''}}">
                                            <select class="selectpicker" data-style="btn btn-primary btn-round" title="Вид на услугата" data-size="{{count($services) + 1}}" name="services" id="services">
                                                <option value="">--Без избор--</option>
                                                @foreach($services as $service)
                                                    <option value="{{ $service->id }}"
                                                            data-minweight="{{$service->minWeight}} "
                                                            data-maxweight="{{$service->maxWeight}}"
                                                            data-priceperkilometer="{{$service->priceLoaded}}">
                                                        {{ $service->name }} : от {{$service->minWeight}} кг. до {{$service->maxWeight}} кг.
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('services'))
                                                <span class="danger" style="margin-top: 7px;">
                                                        {{$errors->first('services')}}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="  form-group label-floating {{$errors->has('orderDate') ? 'has-error' : ''}}">
                                            <label>Дата на поръчката</label>

                                            <input class="date form-control" type="text" name="orderDate" value="{{old('orderDate')}}" id="datepicker">

                                            <span class="material-input"></span>

                                            @if($errors->has('orderDate'))
                                                <span class="danger">
												{{$errors->first('orderDate')}}
											</span>
                                            @endif

                                        </div>
                                </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="map-holder"></div>
                                    <div id="text-holder"></div>
                                </div>
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


                                    <div class="col-md-3">
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
                                        <div class="form-group label-floating {{$errors->has('timeToArrive') ? 'has-error' : ''}}">

                                            <label for="time" > Време в часове</label>
                                            <input class="form-control" name="time" id="time" value="{{old('time')}}">
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
                                            <input type="number" step="0.01" class="form-control" name="price" id="price" value="{{old('price')}}">

                                            @if($errors->has('price'))
                                                <span class="danger">
											{{$errors->first('price')}}
										</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating {{$errors->has('customer_id') ? 'has-error' : ''}}" >
                                            <input type="hidden" class="form-control" name="customer_id" id="customer_id" value="{{Auth::user()->id}}">

                                            @if($errors->has('customer_id'))
                                                <span class="danger">
											{{$errors->first('customer_id')}}
										</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                {{--<form action="{{route('create-order')}}" method="POST">--}}
                                    {{--{{ csrf_field() }}--}}
                                    {{--<input type="hidden" name="orderId" >--}}
                                    {{--<input type="submit" class="btn btn-primary btn-round" value="Подай заявка">--}}
                                {{--</form>--}}



                                <button type="submit" class="btn btn-primary pull-right">Подай заявка</button>
                                </div>
                            </form>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>



@endsection
@section('scripts')
    @parent();



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
                        time.value          = parseFloat(routeData.timeInSeconds.value / 60 / 60, 10).toFixed(2); // time in mins
                        price.value         = parseFloat((routeData.distanceInMeters.value / 1000) * priceKm).toFixed(2);
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

    <script>
        $( function() {

            $( "#datepicker" ).datetimepicker({
                minDate: 0,
                minInterval: (1000*60*60),
                dateFormat: ' yy-mm-dd ',

                timeFormat: 'HH:mm:ss',
                start: {}, // start picker options
                end: {} // end picker options
            });
        });
    </script>

    <style>
        #map-holder {
            height: 320px;
            margin-left: 70px;
            /*width: 750px;*/
        }
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="/assets/js/jquery-ui-timepicker-addon.min.js" type="text/javascript"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">

    <script type="text/javascript" src="{{ URL::asset('assets/js/routeControl.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?callback=onMapLoad&region=BG&key=AIzaSyDJ8-74q6kLtxWZ5egVzUwVzwSkKQiGvzQ"></script>

@endsection