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
						<h4 class="card-title">Всички потребители</h4>
						<div class="toolbar">
						</div>
						<div class="material-datatables">
							<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
								<thead>
									<tr>
										<th>Име</th>
										<th>Фамилия</th>
										<th>Имейл</th>
										<th>ЕГН</th>
										<th>Роля</th>
										<th class="disabled-sorting text-right">Действия</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>Име</th>
										<th>Фамилия</th>
										<th>Имейл</th>
										<th>ЕГН</th>
										<th>Роля</th>
										<th class="disabled-sorting text-right">Действия</th>
									</tr>
								</tfoot>
								<tbody>
									@foreach($users as $user)
									<tr>
										<td>{{$user->firstName}}</td>
										<td>{{$user->lastName}}</td>
										<td>{{$user->email}}</td>
										<td>{{$user->egn}}</td>
										<td>{{$user->role->name}}</td>
										<td class="text-right">
											<a title="Редактиране" data-user="{{$user->id}}"  href="#" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
											<a title="Изтриване" data-user="{{$user->id}}" href="javascript:;" class="btn btn-simple btn-danger btn-icon remove"><i class="material-icons">close</i></a>
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
@parent()

<script>
	$(document).ready(function () {

        $('#datatables').on('click', '.remove', function () {
            if (confirm('Сигурни ли сте?')) {
                var id = $(this).data('user');
                window.location = "/admin/delete-user/" + id;
            }
        });

        $('#datatables').on('click', '.edit', function () {
            var id = $(this).data('user');
            window.location = "/admin/edit-user/" + id;
        });
    });
</script>
@endsection