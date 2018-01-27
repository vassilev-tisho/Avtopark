@extends('manager.manager')
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
                            <h4 class="card-title">Дневник на ремонти на : {{$vehicle->regNumber}} - {{$vehicle->brand}} </h4>
                            <div class="toolbar">
                            </div>
                            <div class="material-datatables">
                                <table id="datatables" class="table table table-striped table-no-bordered table-hover" cellspacing="0"  width="100%" style="width:100%">
                                    <thead>
                                    <tr >
                                        <th>Сервиз</th>
                                        <th>Ремонт / Услуга</th>
                                        <th>Цена</th>
                                        <th>Постъпил за ремонт</th>
                                        <th>Излязъл от ремонт</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr >
                                        <th>Сервиз</th>
                                        <th>Ремонт / Услуга</th>
                                        <th>Цена</th>
                                        <th>Постъпил за ремонт</th>
                                        <th>Излязъл от ремонт</th>
                                    </tr>
                                    </tfoot>
                                    <tbody >
                                    @foreach($brokenVehicles as $brokenVehicle)
                                        <tr>
                                            <td>{{$brokenVehicle->serviceName}}</td>
                                            <td>{{$brokenVehicle->repairType}}</td>
                                            <td>{{$brokenVehicle->price}} лв. </td>
                                            <td>{{$brokenVehicle->dateInRepair}}</td>
                                            <td>{{$brokenVehicle->dateOutRepair}}</td>
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
