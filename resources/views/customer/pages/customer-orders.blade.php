@extends('customer.customer')
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
                            <h4 class="card-title">Моите поръчки</h4>
                            <div class="toolbar">
                            </div>
                            <div class="material-datatables">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Услуга</th>
                                        <th>Начален адрес</th>
                                        <th>Краен адрес</th>
                                        <th>Разстояние</th>
                                        <th>Цена</th>
                                        <th>Статус на поръчката</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Услуга</th>
                                        <th>Начален адрес</th>
                                        <th>Краен адрес</th>
                                        <th>Разстояние</th>
                                        <th>Цена</th>
                                        <th>Статус на поръчката</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{$order->id}}</td>
                                            <td>{{$order->services->name}}</td>
                                            <td>
                                                <div class="item">
                                                    {{ $order->shortAddressSending }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="item">
                                                    {{$order->shortAddressReceiver}}
                                                </div>
                                            </td>
                                            <td>{{$order->kilometres}}</td>
                                            <td>{{$order->price}}</td>
                                            <td>

                                                    @if($order->orderStatus->type == \App\OrderStatus::ORDER_STATUS_SENT)
                                                        <span class="green">{{$order->orderStatus->code}}</span>
                                                    @elseif($order->orderStatus->type == \App\OrderStatus::ORDER_STATUS_PROCESSING)
                                                        <span class="purple">{{$order->orderStatus->code}}</span>
                                                    @elseif($order->orderStatus->type == \App\OrderStatus::ORDER_STATUS_CLOSED)
                                                        <span class="red">{{$order->orderStatus->code}}</span>
                                                    @elseif($order->orderStatus->type == \App\OrderStatus::ORDER_STATUS_NEW)
                                                        <span class="yellow">{{$order->orderStatus->code}}</span>
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
    <script>
        $(function(){ /* to make sure the script runs after page load */

            $('.item').each(function(event){ /* select all divs with the item class */

                var max_length = 70; /* set the max content length before a read more link will be added */

                if($(this).html().length > max_length){ /* check for content length */

                    var short_content 	= $(this).html().substr(0,max_length); /* split the content in two parts */
                    var long_content	= $(this).html().substr(max_length);

                    $(this).html(short_content+
                        '<a href="#" class="read_more"><br/>Read More</a>'+
                        '<span class="more_text" style="display:none;">'+long_content+'</span>'); /* Alter the html to allow the read more functionality */

                    $(this).find('a.read_more').click(function(event){ /* find the a.read_more element within the new html and bind the following code to it */

                        event.preventDefault(); /* prevent the a from changing the url */
                        $(this).hide(); /* hide the read more button */
                        $(this).parents('.item').find('.more_text').show(); /* show the .more_text span */

                    });

                }

            });


        });
    </script>

@endsection