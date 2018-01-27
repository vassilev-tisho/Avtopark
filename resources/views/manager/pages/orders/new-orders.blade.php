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
                            <h4 class="card-title">Нови поръчки, чакащи одобрение</h4>
                            <div class="toolbar">
                            </div>
                            <div class="material-datatables">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                    <tr>
                                        {{--<th>ID</th>--}}
                                        <th>Услуга</th>
                                        <th>Kлиент</th>
                                        <th>Начален адрес</th>
                                        <th>Краен адрес</th>
                                        <th>Разстояние</th>
                                        <th>Статус на поръчката</th>
                                        <th class="disabled-sorting text-right">Действия</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        {{--<th>ID</th>--}}
                                        <th>Услуга</th>
                                        <th>Клиент</th>
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
                                            {{--<td>{{$order->id}}</td>--}}
                                            <td>{{$order->services->name}}</td>
                                            <td>{{$order->customer->fullName}}</td>
                                            <td>{{$order->addressSending}}</td>
                                            <td>{{$order->addressReceiver}}</td>
                                            <td>{{$order->kilometres}}</td>
                                            <td>
                                                @if($order->orderStatus->type == \App\OrderStatus::ORDER_STATUS_NEW)
                                                    <span class="yellow">{{$order->orderStatus->code}}</span>
                                                @elseif($order->orderStatus->type == \App\OrderStatus::ORDER_STATUS_PROCESSING)
                                                    <span class="purple">{{$order->orderStatus->code}}</span>
                                                @elseif($order->orderStatus->type == \App\OrderStatus::ORDER_STATUS_SENT)
                                                    <span class="green">{{$order->orderStatus->code}}</span>


                                                @endif
                                            </td>

                                            <td class="text-right">
                                                <a title="Виж детайли" data-order="{{$order->id}}"  href="#" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">dvr</i></a>
                                                <a title="Изтриване" data-order="{{$order->id}}" href="javascript:;" class="btn btn-simple btn-danger btn-icon remove"><i class="material-icons">close</i></a>
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
            $('.edit').on('click', function () {
                var orderId = $(this).data('order');
                window.location = "/manager/edit-order/" + orderId;
            });
        });
    </script>
@endsection