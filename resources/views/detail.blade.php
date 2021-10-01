@extends('layouts.shop')

@section('content')
<link rel="stylesheet" href="{{asset('css/cart_detail.css')}}">
<script type="text/javascript">
//tim kiem san pham
// $(document).ready(function(){
//     $('.header__search-history').mousedown(function(e){
//         e.preventDefault();
//     });
//     $('.header__search-input').keyup(function(){
        
//         var txt=$('.header__search-input').val();
//         if(txt ==''){
//             $('.header__search-history').html('');
//         }else{

//             var token = $("input[name='_token']").val();

//             var search_value= $(".header__search-input").val();

//             var data_js ={search_value:search_value, "_token":token }

//             $.ajaxSetup({
//                 headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                     }
//             });
//             $.ajax({
//                 url:"{{route('cart.search_ajax')}}",
//                 method:'POST',
//                 data:data_js,
//                 dataType:'text',
//                 success:function($output){
//                     $('.header__search-history').html($output);       
//                 },
//                 error:function(xhr,ajaxOptions,thrownError){
//                     alert(xhr.status);
//                     alert(thrownError);
//                 }
//             });
//         }
//     });
// });
    $(document).ready(function(){
        $("#num_order").change(function(){
            var token = $("input[name='_token']").val();

            var num_order=$("#num_order").val();

            var price=$(".price").attr('value');

            var data_js ={num_order:num_order, price:price, "_token":token }

            $.ajax({ 
            url:"{{route('cart.ajax_detail')}}",
            method: 'POST',
            data: data_js,
            dataType:'json',
            success:function(data_php){
                $(".price").text(data_php.total+"đ");
            },
            error:function(xhr,ajaxOptions,thrownError){
                alert(xhr.status);
                alert(thrownError);
            }

        });
        });
    });

</script>  
<div class="app__container container-fluid">
    <div class="grid">
        <div class="grid__row app__content ">    
            <div class="grid__column-2 hidden-sm-down col-lg-2 col-xl-2">
                <nav class="category">
                    <h3 class="category__heading">
                        <i class="category__heading-icon fas fa-list-ul"></i>
                        Danh Mục
                    </h3>
                    <ul class="category-list">
                        
                        <li class="category-item category-item--active">
                            <a href="" class="category-item__link">Tât cả sản phẩm</a>
                        </li>
                        <li class="category-item">
                            <a href="" class="category-item__link">Điện thoại</a>
                        </li>
                        <li class="category-item">
                            <a href="" class="category-item__link">Laptop</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="hidden-sm-up col-sm-1 col-xs-1"></div>
            <div class="grid__column-10 col-md-10 col-lg-10 col-sm-10 col-xs-10 ">               
                <div class="home-product">
                    <!-- grid -> row -> column -->
                    @php
                        if(!empty($product ->discount)){
                            $price=$product->price/1000;
                            $price_new=ceil($price - ($price* $product ->discount/100))*1000;
                    }    
                    @endphp              
                    <div id="content" class="fl-right">
                        <div class="section" id="info-product-wp">
                            <div class="section-detail">
                                <div class="thumb">
                                    <img src="{{$product->product_img}}" alt="">
                                </div>
                                <div class="detail">
                                    <h3 class="title">{{$product->name}}</h3>
                                    @if(isset($price_new))
                                    <p class="price" name="price" value="{{$price_new}}">{{number_format($price_new,0,",",".")}}đ</p>
                                    @else
                                    <p class="price" name="price" value="{{$product->price}}">{{number_format($product->price,0,",",".")}}đ</p>
                                    @endif
                                    <p class="product-code">Thương hiệu: <span>{{$product->trademark}}</span></p>
                                    <div class="desc-short">
                                        <h5>Mô tả sản phẩm:</h5>
                                        <p>{{$product->content}}</p>
                                    </div>
                                    <div class="num-order-wp">
                                        <span>Số lượng:</span>
                                        <input type="number" min="1" id="num_order" name="num_order" value="1"> 
                                        <a href="{{route('cart.add', $product->id)}}" title="" class="add-to-cart">Thêm giỏ hàng</a>
                                    </div>
            
                                </div>
                            </div>
                        </div>
                        <div class="section-content" id="desc-wp">
                            <div class="section-head">
                                <h2 class="section-title">Chi tiết sản phẩm</h2>
                            </div>
                            <div class="content-detail">
                                <p>Tên sản phẩm: {{$product->name}}</p>
                                <p>Sản xuất tại: {{$product->country}}</p>
                                <p>Thương Hiệu: {{$product->trademark}}</p>
                                <p>Mô tả: {{$product->content}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>
@endsection