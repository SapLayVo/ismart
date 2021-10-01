@extends('layouts.admin')

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col information_buy" >
            <div class="card text-white bg-primary mb-6" style="max-width: 36rem;">
                <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                <div class="card-body">
                    <h5 class="card-title">{{number_format($count_order_active,0,',','.')}}</h5>
                    <p class="card-text">Đơn hàng giao dịch thành công</p>
                </div>
            </div>
        </div>
        {{-- <div class="col">
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐANG XỬ LÝ</div>
                <div class="card-body">
                    <h5 class="card-title">10</h5>
                    <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header">DOANH SỐ</div>
                <div class="card-body">
                    <h5 class="card-title">2.5 tỷ</h5>
                    <p class="card-text">Doanh số hệ thống</p>
                </div>
            </div>
        </div> --}}
        <div class="col information_buy">
            <div class="card text-white bg-dark mb-6" style="max-width: 36rem;">
                <div class="card-header">ĐƠN HÀNG HỦY</div>
                <div class="card-body">
                    <h5 class="card-title">{{number_format($count_order_trash,0,',','.')}}</h5>
                    <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end analytic  -->
    <div class="card">
        <div class="card-header font-weight-bold">
            ĐƠN HÀNG MỚI
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Mã</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Giá trị</th>
                        <th scope="col">Thời gian</th>
                    </tr>
                </thead>
                @if($orders->count()>0)
                <tbody>
                    @php
                    isset($_GET['page'])?$page=$_GET['page']:$page=1;
                    $index = ($page-1)*$num_per_page;
                    @endphp
                    @foreach($orders as $order)
                    @php
                    $index++;  
                    @endphp 
                    <tr>        
                        <td>{{$index}}</td>
                        <td>#{{$order->user_id}}{{$order->id}}</td>
                        <td>{{$order->name_user}}</td>
                        <td><a href="{{route('detail', $order->product_id)}}">{{$order->name_product}}</a></td>
                        <td>{{$order->num_order}}</td>
                        <td>{{number_format($order->num_order*$order->price,0,",",".")}}đ</td>
                        <td>{{$order->created_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
                @endif
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                       {{$orders->links()}}
                    </li>
                </ul>
            </nav>
        </div>
    </div>

</div>
@endsection