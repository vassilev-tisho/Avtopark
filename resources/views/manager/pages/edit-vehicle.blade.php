@extends('manager.manager')
@section('content')
{{--<div class="content">--}}
	<div class="container-fluid" style="margin-top: 50px;">
		<div class="row">
			<div class="col-md-9">
				<div class="card">
					<div class="card-header" data-background-color="purple">
						<h4 class="title">Редактиране на превозно средство</h4>
						<p class="category">Тук е форма за редактиране на съществуващи превозни средства</p>
					</div>
					<div class="card-content">
						<div class="card-content">
							<form method="POST">
								{{ csrf_field() }}

								<div class="row">
									<div class="col-md-3">
										<div class="form-group label-floating {{$errors->has('brand') ? 'has-error' : ''}}">
											<label  class="control-label" for="brand">Марка</label>
											<input type="text" class="form-control" name="brand" id="name" value="{{$vehicle->brand}}">

											@if($errors->has('brand'))
											<span class="danger">
												{{$errors->first('brand')}}
											</span>
											@endif
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group label-floating {{$errors->has('regNumber') ? 'has-error' : ''}}">
											<label class="control-label">Регистрационен номер</label>
											<input type="text" class="form-control" name="regNumber" value="{{$vehicle->regNumber}}">

											@if($errors->has('regNumber'))
											<span class="danger">
												{{$errors->first('regNumber')}}
											</span>
											@endif
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4">
										<div class="form-group label-floating {{$errors->has('vehicle_engine') ? 'has-error' : ''}} ">
											<select class="selectpicker" data-style="btn btn-primary btn-round" title="Тип на двигателя" data-size="4" name="vehicle_engine" id="vehicle_engine">
												<option value="">--Без избор--</option>
												<option value="benz" @if($vehicle->fuelType == 'benz') selected=selected @endif >Бензин</option>
												<option value="dizel" @if($vehicle->fuelType == 'dizel') selected=selected @endif >Дизел</option>
												<option value="agu" @if($vehicle->fuelType == 'agu') selected=selected @endif >АГУ</option>
											</select>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group label-floating {{$errors->has('vehicle_type') ? 'has-error' : ''}}">
											<select class="selectpicker" data-style="btn btn-primary btn-round" title="Тип на МПС" data-size="{{count($vehicleTypes) + 1}}" name="vehicle_type" id="vehicle_type">
												<option value="">--Без избор--</option>
												@foreach($vehicleTypes as $vehicleType)
												<option value="{{ $vehicleType->id }}" @if($vehicle->vehicle_types->id == $vehicleType->id) selected=selected @endif>{{ $vehicleType->code }}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group label-floating {{$errors->has('vehicle_status') ? 'has-error' : ''}}">
											<select class="selectpicker" data-style="btn btn-primary btn-round" title="Статус на МПС" data-size="{{count($vehicleStatuses) + 1}}" name="vehicle_status_id" id="vehicle_status_id">
												<option value="">--Без избор--</option>
												@foreach($vehicleStatuses as $vehicleStatus)
												<option  data-code={{$vehicleStatus->type}} value="{{ $vehicleStatus->id }}"
														 @if($vehicle->status->id == $vehicleStatus->id)
														 	selected=selected
												   		@endif>
															{{ $vehicleStatus->code }}
												</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>


								<div class="row">
									<div class="col-md-3">
										<div class="form-group label-floating {{$errors->has('driveLicenseNeed') ? 'has-error' : ''}}">
											<label class="control-label">Необходима шофьорска книжка</label>
											<input type="text" class="form-control" name="driveLicenseNeed" id="driveLicenseNeed" value="{{$vehicle->driveLicenseNeed}}">

											@if($errors->has('driveLicenseNeed'))
												<span class="danger">
													{{$errors->first('driveLicenseNeed')}}
												</span>
											@endif
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group label-floating {{$errors->has('fuelConsumption') ? 'has-error' : ''}}">
											<label class="control-label">Разход на гориво</label>
											<input type="text" class="form-control" name="fuelConsumption" value="{{$vehicle->fuelConsumption}}">

											@if($errors->has('fuelConsumption'))
											<span class="danger">
												{{$errors->first('fuelConsumption')}}
											</span>
											@endif
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group label-floating {{$errors->has('mileage') ? 'has-error' : ''}}">
											<label class="control-label">Изминати километри</label>
											<input type="text" class="form-control" name="mileage" value="{{$vehicle->mileage}}">

											@if($errors->has('mileage'))
												<span class="danger">
												{{$errors->first('mileage')}}
											</span>
											@endif
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group label-floating {{$errors->has('chargeWeight') ? 'has-error' : ''}}">
											<label class="control-label">Полезен товар</label>
											<input type="text" class="form-control" name="chargeWeight" value="{{$vehicle->chargeWeight}}">

											@if($errors->has('chargeWeight'))
												<span class="danger">
												{{$errors->first('chargeWeight')}}
											</span>
											@endif
										</div>
									</div>

								</div>





								<div class="row">
									<div class="col-md-5">
										<div class="form-group label-floating {{$errors->has('insurance') ? 'has-error' : ''}}">
											<label>Гражданска Отговорност/изтича/</label>
											<input type="date" class="form-control" name="insurance" value="{{$vehicle->insurance}}">

											@if($errors->has('insurance'))
												<span class="danger">
													{{$errors->first('insurance')}}
												</span>
											@endif

										</div>
									</div>

									<div class="col-md-5">
										<div class="form-group label-floating {{$errors->has('technicalReview') ? 'has-error' : ''}}">
											<label>Технически преглед/изтича/</label>
											<input type="date" class="form-control" name="technicalReview" value="{{$vehicle->technicalReview}}">

											@if($errors->has('technicalReview'))
											<span class="danger">
												{{$errors->first('technicalReview')}}
											</span>
											@endif
										</div>
									</div>
								</div>



								<br>
								<input type="hidden" name="vhid" value="{{$vehicle->id}}" />


									<div id="OnRepair_cont" class="row @if($vehicle->status->type != 'OnRepair') hiddenfield @endif">
										<div class="col-md-3" >
											<div class="form-group label-floating {{$errors->has('dateInRepair') ? 'has-error' : ''}}">
												<label >Дата на приемане</label>
												<input type="date" class="form-control" name="dateInRepair" value="{{$vehicleRepairData['dateInRepair']}}">
											</div>

											@if($errors->has('dateInRepair'))
												<span class="danger">
												{{$errors->first('dateInRepair')}}
											</span>
											@endif
										</div>
										<div class="col-md-4">
											<div class="form-group label-floating {{$errors->has('serviceName') ? 'has-error' : ''}}">
												<label >Сервиз</label>
												<input type="text" class="form-control" name="serviceName" value="{{$vehicleRepairData['serviceName']}}">
											</div>
											@if($errors->has('serviceName'))
												<span class="danger">
													{{$errors->first('serviceName')}}
												</span>
											@endif
										</div>
										<div class="col-md-4">
											<div class="form-group label-floating {{$errors->has('repairType') ? 'has-error' : ''}}">
												<label>Вид ремонт или услуга</label>
												<input type="text" class="form-control" name="repairType" value="{{$vehicleRepairData['repairType']}}">
											</div>
											@if($errors->has('repairType'))
												<span class="danger">
													{{$errors->first('repairType')}}
												</span>
											@endif
										</div>
										<div class="col-md-3" {{$errors->has('price') ? 'has-error' : ''}}>
											<div class="form-group label-floating">
												<label>Цена</label>
												<input type="text" class="form-control" name="price" value="{{$vehicleRepairData['price']}}">
											</div>
											@if($errors->has('price'))
												<span class="danger">
													{{$errors->first('price')}}
												</span>
											@endif
										</div>
									</div>


								<div id="OnRepairToFree_cont" class="row hiddenfield">
									<div class="col-md-3" {{$errors->has('dateOutRepair') ? 'has-error' : ''}}>
									<div class="form-group label-floating {{$errors->has('dateOutRepair') ? 'has-error' : ''}}">
										<label >Дата на излизане от сервиза</label>
										<input type="date" class="form-control" name="dateOutRepair" value="{{$vehicleRepairData['dateOutRepair']}}">
									</div>

									@if($errors->has('dateOutRepair'))
										<span class="danger">
												{{$errors->first('dateOutRepair')}}
											</span>
									@endif
								</div>
								</div>

								<button type="submit" class="btn btn-primary pull-right">Запази</button>
								<div class="clearfix"></div>
							</form>
						</div>


					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{{--</div>--}}
@endsection
@section('scripts')
	<script>
        $('#vehicle_status_id').on('change', function () {

			var code = $(this).find('option:selected').data('code');
			if(code === 'OnRepair'){
				$('#OnRepair_cont').removeClass('hiddenfield');
			}else{
                $('#OnRepair_cont').addClass('hiddenfield');
			}

            if(code === 'Free'){
                $('#OnRepairToFree_cont').removeClass('hiddenfield');
            }else{
                $('#OnRepairToFree_cont').addClass('hiddenfield');
            }


        });
	</script>
@endsection