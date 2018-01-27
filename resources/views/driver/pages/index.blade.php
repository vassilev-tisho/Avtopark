@extends('driver.driver')
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
							<h4 class="card-title">Нови поръчки</h4>
							<div class="toolbar">
							</div>
							<div class="material-datatables">
								<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
									<thead>
									<tr>
										<th>ID</th>
										<th>Услуга</th>
										<th>МПС</th>
										<th>Начален адрес</th>
										<th>Краен адрес</th>
										<th>Разстояние</th>
										<th>Статус на поръчката</th>
										<th class="disabled-sorting text-right">Действия</th>
									</tr>
									</thead>
									<tfoot>
									<tr>
										<th>ID</th>
										<th>Услуга</th>
										<th>МПС</th>
										<th>Начален адрес</th>
										<th>Краен адрес</th>
										<th>Разстояние</th>
										<th>Статус на поръчката</th>
										<th class="disabled-sorting text-right">Действия</th>
									</tr>
									</tfoot>
									<tbody>
									@foreach($orders as $order)
										<tr>
											<td>{{$order->id}}</td>
											<td>{{$order->services->name}}</td>
											<td>{{$order->vehicles->brand}}</td>
											<td>{{$order->addressSending}}</td>
											<td>{{$order->addressReceiver}}</td>
											<td>{{$order->kilometres}}</td>
											<td>
												@if(isset($order->orderStatus))
													<span class="purple">{{$order->orderStatus->code}}</span>
												@else
													&nbsp;
												@endif
											</td>
											<td class="text-right">
												@if($order->orderStatus->type != \App\OrderStatus::ORDER_STATUS_SENT && $order->orderStatus->type != \App\OrderStatus::ORDER_STATUS_CLOSED)
													<form action="{{route('startOrder')}}" method="POST">
														{{ csrf_field() }}
														<input type="hidden" name="orderId" value="{{$order->id}}">
														<input type="submit" class="btn btn-primary btn-round" value="Започвам">
													</form>
												@endif
												@if($order->orderStatus->type == \App\OrderStatus::ORDER_STATUS_SENT && $order->orderStatus->type != \App\OrderStatus::ORDER_STATUS_CLOSED)
													<form action="{{route('endOrder')}}" method="POST">
														{{ csrf_field() }}
														<input type="hidden" name="orderId" value="{{$order->id}}">
														<input type="submit" class="btn btn-primary btn-round" value="Приключвам">
													</form>
												@endif
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

            $(document).on('click','.startOrder', function () {
                if (confirm('Сигурни ли сте?')) {
                    var orderId = $(this).data('order');
                    window.location = "/driver/start-order/" + orderId;
                }
            });
            $(document).on('click','.endOrder', function () {
                if (confirm('Сигурни ли сте?')) {
                    var orderId = $(this).data('order');
                    window.location = "/driver/end-order/" + orderId;
                }
            });
        });
	</script>
@endsection