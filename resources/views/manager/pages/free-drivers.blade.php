@extends('manager.manager')
@section('content')
    <div class="content">
        <form method="GET">
            {{ csrf_field() }}
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" >
                            <div class="card-header card-header-icon" data-background-color="purple">
                                <i class="material-icons">assignment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Свободни шофьори към дата :{{Carbon\Carbon::now(new DateTimeZone('Europe/Sofia'))}}</h4>
                                <div class="toolbar">
                                </div>
                                <div class="material-datatables">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="  form-group label-floating ">
                                                <label>Свободни шофьори</label>
                                                <input class="date form-control" type="date" name="orderSearchDate" value="{{$filterDate}}">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="  form-group label-floating ">
                                                <button type="submit" class="btn btn-primary">Покажи</button>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="datatables" class="table table table-striped table-no-bordered table-hover" cellspacing="0" >
                                        <thead>

                                        <tr >
                                            <th>Име</th>
                                            <th>Фамилия</th>
                                            <th>Правоспособност</th>
                                            <th>Изтича на</th>
                                            {{--<th>Статус <br><i style="font-size:11px;">(към днескашна дата)</i></th>--}}
                                            {{--<th>Разход</th>--}}
                                            {{--<th>Километри</th>--}}
                                            {{--<th>Полезен товар</th>--}}
                                            {{--<th class="disabled-sorting text-right">Действия</th>--}}
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr >
                                            <th>Име</th>
                                            <th>Фамилия</th>
                                            <th>Правоспособност</th>
                                            <th>Изтича на</th>
                                            {{--<th >Статус на МПС</th>--}}
                                            {{--<th>Разход на гориво</th>--}}
                                            {{--<th>Изминати километри</th>--}}
                                            {{--<th>Полезен товар</th>--}}
                                            {{--<th class="disabled-sorting text-right">Действия</th>--}}
                                        </tr>
                                        </tfoot>
                                        <tbody >
                                        @foreach($freeDrivers as $driver)

                                            <tr>

                                                <td>
                                                    <a data-id="{{$driver->id}}"  href="#" class="btn btn-simple btn-facebook btn-icon edit"><i>{{$driver->firstName}}</i></a>
                                                </td>

                                                <td>
                                                    <a data-id="{{$driver->id}}"  href="#" class="btn btn-simple btn-facebook btn-icon edit"><i>{{$driver->lastName}}</i></a>
                                                </td>
                                                <td>{{$driver->driveLicenseCategory}}</td>
                                                <td>{{$driver->driveLicenseExpired}}</td>
                                                {{--<td>{{$vehicle->insurance}}</td>--}}
                                                {{--<td>{{$vehicle->technicalReview}}</td>--}}
                                                {{--<td class="text-right">--}}
                                                {{--<a title="Профил" data-id="{{$vehicle->vehicle_id}}"  href="#" class="btn btn-simple btn-warning btn-icon fileinput-preview"><i class="material-icons">find_in_page</i></a>--}}
                                                {{--<a title="Ремонт" data-id="{{$vehicle->vehicle_id}}"  href="#" class="btn btn-simple btn-success btn-icon build"><i class="material-icons">build</i></a>--}}
                                                {{--<a title="Редактиране" data-id="{{$vehicle->id}}"  href="{{ route('edit-vehicle', ['id'=>$vehicle->id]) }}" class="btn btn-simple btn-facebook btn-icon edit"><i class="material-icons">edit</i></a>--}}
                                                {{--<a title="Изтриване" data-id="{{$vehicle->vehicle_id}}" href="javascript:;" class="btn btn-simple btn-danger btn-icon remove"><i class="material-icons">close</i></a>--}}
                                                {{--</td>--}}

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
        </form>
    </div>
    </div>

@endsection
@section('scripts')
    @parent;

    <script>
        $(document).ready(function() {

            $('#datatables').click(function() {
                var href = $(this).find("a").attr("href");
                if(href) {
                    window.location = href;
                }
            });

        });
    </script>
@endsection