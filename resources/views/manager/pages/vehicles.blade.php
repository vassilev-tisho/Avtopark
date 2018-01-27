@extends('manager.manager')
@section('content')

	<div class="content" style="margin-top: 5px;">
		{{--<div class="container-fluid">--}}
			<div class="row" >
				<div class="col-md-12">
					<div class="card" >
						<div class="card-header card-header-icon" data-background-color="purple">
							<i class="material-icons">assignment</i>
						</div>
						<div class="card-content">
							<h4 class="card-title">Състояние на всички превозни средства към дата :{{Carbon\Carbon::now(new DateTimeZone('Europe/Sofia'))}}</h4>
							<div class="toolbar">
							</div>
							<div class="material-datatables">
								<table id="datatables" class="table table table-striped table-no-bordered table-hover" cellspacing="0"  width="100%" style="width:100%">
									<thead>
									<tr >
										<th>Марка</th>
										<th>Номер</th>
										<th>Двигател</th>
										<th>Тип</th>
										<th>Статус</th>
										{{--<th>Разход</th>--}}
										<th>Километри</th>
										<th>Товар</th>
										<th class="disabled-sorting text-right">Действия</th>
									</tr>
									</thead>
									<tfoot>
									<tr >
										<th>Марка</th>
										<th>Регистрационен номер</th>
										<th>Тип на двигателя</th>
										<th>Тип на МПС</th>
										<th >Статус на МПС</th>
										{{--<th>Разход на гориво</th>--}}
										<th>Изминати километри</th>
										<th>Полезен товар</th>
										<th class="disabled-sorting text-right">Действия</th>
									</tr>
									</tfoot>
									<tbody >
									@foreach($vehicles as $vehicle)
										<tr>
											<td>{{$vehicle->brand}}</td>
											<td>{{$vehicle->regNumber}}</td>
											<td>
												@if($vehicle->fuelType=='benz')
													Бензин
												@elseif($vehicle->fuelType=='dizel')
													Дизел
												@elseif($vehicle->fuelType=='agu')
													АГУ
												@endif
											</td>
											<td>{{$vehicle->vehicle_types->code}} </td>
											@if($vehicle->status->type=="OnRoad" )
												<td  ><span class="red">{{$vehicle->status->code}}</span></td>
											@elseif($vehicle->status->type=="Free")
												<td  ><span class="green">{{$vehicle->status->code}}</span></td>
											@elseif($vehicle->status->type=="OnRepair")
												<td  ><span class="purple">{{$vehicle->status->code}}</span></td>
											@elseif($vehicle->status->type=="Reserved")
												<td  ><span class="yellow">{{$vehicle->status->code}}</span></td>
											@endif

											{{--<td>{{$vehicle->fuelConsumption}}</td>--}}
											<td>{{$vehicle->mileage}}</td>
											<td>{{$vehicle->chargeWeight}}</td>
											{{--<td>{{$vehicle->insurance}}</td>--}}
											{{--<td>{{$vehicle->technicalReview}}</td>--}}
											<td class="text-right">
												<a title="Профил" data-id="{{$vehicle->id}}"  href="#" class="btn btn-simple btn-warning btn-icon fileinput-preview"><i class="material-icons">find_in_page</i></a>
												<a title="Ремонт" data-id="{{$vehicle->id}}"  href="#" class="btn btn-simple btn-success btn-icon build"><i class="material-icons">build</i></a>
												<a title="Редактиране" data-id="{{$vehicle->id}}"  href="#" class="btn btn-simple btn-facebook btn-icon edit"><i class="material-icons">edit</i></a>
												<a title="Изтриване" data-id="{{$vehicle->id}}" href="javascript:;" class="btn btn-simple btn-danger btn-icon remove"><i class="material-icons">close</i></a>
											</td>
										</tr>
									@endforeach
									</tbody>
								</table>
							</div>
						</div>
						<!-- end content-->
					</div>
					<!--  end card  -->
				</div>
				<!-- end col-md-12 -->
			</div>
			<!-- end row -->
		</div>
	{{--</div>--}}
	</div>
@endsection
@section('scripts')
	@parent();
	<script>
        $(document).ready(function () {

            $('#datatables').on('click', '.remove', function(){
                if (confirm('Сигурни ли сте, че изкате да изтриете това превозно средство?')) {
                    var id = $(this).data('id');
                    window.location = "/manager/delete-vehicle/" + id;
                }
            });

            $('#datatables').on('click', '.edit', function(){
                var id = $(this).data('id');
                window.location = "/manager/edit-vehicle/" + id;
            });

            $('#datatables').on('click', '.fileinput-preview', function(){
                var id = $(this).data('id');
                window.location = "/manager/vehicle-profile/" + id;
            });

            $('#datatables').on('click', '.build', function(){
                var id = $(this).data('id');
                window.location = "/manager/vehicle-repair-profile/" + id;
            });

        });
	</script>
@endsection