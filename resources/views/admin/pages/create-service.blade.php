@extends('admin.admin')
@section('content')
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header" data-background-color="purple">
						<h4 class="title">Създаване на услуга</h4>
						<p class="category">Форма за създаване на нова услуга</p>
					</div>
					<div class="card-content">
						<form method="POST">
							{{ csrf_field() }}
							<div class="row">
								<div class="col-md-6">
									<div class="form-group label-floating {{$errors->has('name') ? 'has-error' : ''}}" >
										<label  class="control-label" for="name">Име</label>
										<input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">

										@if($errors->has('name'))
										<span class="danger">
											{{$errors->first('name')}}
										</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group label-floating {{$errors->has('description') ? 'has-error' : ''}}" style="padding-top: 2px;">
										<label  class="control-label" for="description">Описание</label>
										<textarea class="form-control" rows="1" name="description">{{old('description')}}</textarea>

										@if($errors->has('description'))
										<span class="danger">
											{{$errors->first('description')}}
										</span>
										@endif
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group label-floating {{$errors->has('priceLoaded') ? 'has-error' : ''}}" >
										<label  class="control-label" for="priceLoaded">Цена натоварен</label>
										<input type="number" step="0.01" class="form-control" name="priceLoaded" id="priceLoaded" value="{{old('priceLoaded')}}">

										@if($errors->has('priceLoaded'))
										<span class="danger">
											{{$errors->first('priceLoaded')}}
										</span>
										@endif
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group label-floating {{$errors->has('priceUnLoaded') ? 'has-error' : ''}}" >
										<label  class="control-label" for="priceUnLoaded">Цена празен</label>
										<input type="number" step="0.01" class="form-control" name="priceUnLoaded" id="priceUnLoaded" value="{{old('priceUnLoaded')}}">

										@if($errors->has('priceUnLoaded'))
										<span class="danger">
											{{$errors->first('priceUnLoaded')}}
										</span>
										@endif
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group label-floating {{$errors->has('minWeight') ? 'has-error' : ''}}" >
										<label  class="control-label" for="minWeight">Минимален товар</label>
										<input type="number" class="form-control" name="minWeight" id="minWeight" value="{{old('minWeight')}}">

										@if($errors->has('minWeight'))
										<span class="danger">
											{{$errors->first('minWeight')}}
										</span>
										@endif
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group label-floating {{$errors->has('maxWeight') ? 'has-error' : ''}}" >
										<label  class="control-label" for="maxWeight">Максимален товар</label>
										<input type="number" class="form-control" name="maxWeight" id="maxWeight" value="{{old('maxWeight')}}">

										@if($errors->has('minWeight'))
										<span class="danger">
											{{$errors->first('maxWeight')}}
										</span>
										@endif
									</div>
								</div>
							</div>
							<button type="submit" class="btn btn-primary pull-right">Create Service</button>
						</form>
					</div>

					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection