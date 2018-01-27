@extends('admin.admin')
@section('content')
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-icon" data-background-color="purple">
						<i class="material-icons">assignment</i>
					</div>
					<div class="card-content">
						<h4 class="card-title">Всички услуги</h4>
						<div class="toolbar">
						</div>
						<div class="material-datatables">
							<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
								<thead>
									<tr>
										<th>Име</th>
										<th>Описание</th>
										<th>Цена натоварен</th>
										<th>Цена празен</th>
										<th>Минимален товар</th>
										<th>Максимален товар</th>
										<th class="disabled-sorting text-right">Действия</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>Име</th>
										<th>Описание</th>
										<th>Цена натоварен</th>
										<th>Цена празен</th>
										<th>Минимален товар</th>
										<th>Максимален товар</th>
										<th class="disabled-sorting text-right">Действия</th>
									</tr>
								</tfoot>
								<tbody>
									@foreach($services as $service)
									<tr>
										<td>{{$service->name}}</td>
										<td>{{$service->description}}</td>
										<td>{{$service->priceLoaded}}</td>
										<td>{{$service->priceUnLoaded}}</td>
										<td>{{$service->minWeight}}</td>
										<td>{{$service->maxWeight}}</td>
										<td class="text-right">
											<a title="Редактиране" data-service="{{$service->id}}"  href="#" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">dvr</i></a>
											<a title="Изтриване" data-service="{{$service->id}}" href="javascript:;" class="btn btn-simple btn-danger btn-icon remove"><i class="material-icons">close</i></a>
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
</div>
</div>
@endsection
@section('scripts')
@parent();
<script>
	$(document).ready(function () {
		$('.remove').on('click', function () {
			if (confirm('Сигурни ли сте?')) {
				var serviceId = $(this).data('service');
				window.location = "/admin/delete-service/" + serviceId;
			}
		});

		$('.edit').on('click', function () {
			var serviceId = $(this).data('service');
			window.location = "/admin/edit-service/" + serviceId;
		});

	});
</script>
@endsection