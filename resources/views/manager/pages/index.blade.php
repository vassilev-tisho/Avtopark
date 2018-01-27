@extends('manager.manager')
@section('content')
<div class="content">
	<h4>Control Panel - Manager</h4>

<div class="row">

	<div class="col-md-3">
		<div class="card card-stats">
			<div class="card-header" data-background-color="orange">
				<i class="material-icons">content_copy</i>
			</div>
			<div class="card-content">

				<p class="category">{{$orders->count()}}<small> нови поръчки</small></p>
				<h4>Нови поръчки</h4>
			</div>
			<div class="card-footer">
				<div class="stats">
					<li><a  href="{{ route('new-orders') }}"> Към нови поръчки...</a></li>
				</div>
			</div>
		</div>

	</div>
	<div class="col-md-3">

			<div class="card card-stats">
				<div class="card-header" data-background-color="green">
					<i class="material-icons">store</i>
				</div>
				<div class="card-content">
					<p class="category">{{$orders->count()}}<small> всички поръчки</small></p>
					<h4 class="title">Всички поръчки</h4>
				</div>
				<div class="card-footer">
					<div class="stats">
						<li><a  href="{{ route('show-orders') }}"> Към всички поръчки...</a></li>
					</div>
				</div>
			</div>

	</div>

		<div class="col-md-3">
			<div class="card card-stats">
				<div class="card-header" data-background-color="red">
					<i class="material-icons">info_outline</i>
				</div>
				<div class="card-content">
					<p class="category">Автопарк</p>
					<h4 class="title">{{$vehicles->count()}}</h4>
				</div>
				<div class="card-footer">
					<div class="stats">
						<i class="material-icons">local_offer</i> <li><a  href="{{ route('show-vehicles') }}"> Към превозни средства...</a></li>
					</div>
				</div>
			</div>
		</div>


		<div class="col-md-3">
			<div class="card card-stats">
				<div class="card-header" data-background-color="blue">
					<i class="fa fa-twitter"></i>
				</div>

				<div class="card-content">
					<h4 class="title">Клиенти</h4>
					<p class="category"><span class="text-success"><i class="fa fa-long-arrow-up"></i> </span> {{App\User::where('role_id', '=', 3)->count()}}</p>
				</div>
				<div class="card-footer">
					<div class="stats">
						<i class="material-icons">access_time</i> updated 4 minutes ago
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection