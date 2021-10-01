@extends('layouts.shop')

@section('content')
<script src="{{asset('js/update_cart.js')}}"></script>
<script type="text/javascript">
//cap nhat gio hang 
// $(document).ready(function(){
//     $(".num_order").change(function(){
//         var token = $("input[name='_token']").val();

//         var id = $(this).attr('data-id');
//         var price = $("#price-"+id).text();
//         var num_order = $("#num_order-"+id).val();

//         var data_js = {num_order: num_order,price:price, id:id,"_token":token }
        
//         $.ajax({ 
//             url:"{{route('cart.ajax')}}",
//             method: 'POST',
//             data: data_js,
//             dataType:'json',
//             success:function(data_php){
//                 $(".total-"+id).text(data_php.total+"đ");
//                 $("#cart_total").text(data_php.total_all+"đ");
//                 $(".notification_count").text("hiện tại có "+data_php.count+" trong giỏ hàng");
//                 $(".header__cart-notice").text(data_php.count)
//             },
//             error:function(xhr,ajaxOptions,thrownError){
//                 alert(xhr.status);
//                 alert(thrownError);
//             }

//         });
//     });
// });

</script>
<link rel="stylesheet" href="{{asset('css/cart_show.css')}}">  
        <!-- end header -->
        <div id="wp-content">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1>Giỏ hàng</h1>
                        <p class="notification_count">hiện tại có {{Cart::count()}} trong giỏ hàng</p>
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                        @endif
                        @if(Cart::count()>0)
                        <form>
                            @csrf
                        <table class="table">
                            <thead>
                                <tr class="title">          
                                    <th scope="col">STT</th>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Thành tiền</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t=0;   
                                @endphp
                                @foreach(Cart::content() as $row)
                                @php
                                    $t++;   
                                @endphp
                                <tr>
                                    <td scope="row">{{$t}}</td>
                                    <td>
                                        <img src="{{$row->options->img}}" width="100px" alt="">
                                    </td>
                                    <td scope="col"><a href="{{route('detail', $row->id)}}">{{$row->name}}</a></td>
                                    <td scope="col" id="price-{{$row->id}}" name="price" >{{number_format($row->price,0,",",".")}}đ</td>
                                    <td scope="col">
                                        <input type="number" min="1" name="num_order" data-id="{{$row->id}}" class="num_order" id="num_order-{{$row->id}}" style="width:50px; text-align: center" value="{{$row->qty}}">
                                    </td>
                                    <td scope="col" class='total-{{$row->id}}'>{{number_format($row->total,0,",",".")}}đ</td>
                                    <td><a href="{{route('cart.remove',$row->rowId)}}" class="text-danger">Xóa</a></td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><a href="{{route('cart.destroy')}}">Xóa giỏ hàng</a></td>
                                    {{-- <td colspan='6' class="text-right"></td> --}}
                                    <td colspan='16' class="text-right cart_total" >Tổng: <strong id="cart_total">{{Cart::total()}}đ</strong></td>
                                </tr>
                            </tfoot> 
                        </table>
                        <div class="buy">
                            <a href="{{route('cart.buy')}}" title="" class="buy_link">Mua hàng</a>
                        </div>
                        
                    </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- end wp-content -->
    </div>
@endsection