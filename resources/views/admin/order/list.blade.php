@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách đơn hàng</h5>
            <div class="form-search form-inline">
                <form action="" method="GET">
                    <input type="" class="form-control form-search" name="keyword" value="{{request()->input('keyword')}}" placeholder="Tìm kiếm">
                    <input type="submit" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['page'=>1,'category'=>'active'])}}" class="text-primary">Tất cả các đơn<span class="text-muted">({{$count_order_active}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['page'=>1,'category'=>'trash'])}}" class="text-primary">Đơn hủy<span class="text-muted">({{$count_order_trash}})</span></a>
            </div>
            <form action="{{url('admin/order/option')}}">
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" name="action" id="">
                    <option value="">Chọn</option>
                    @foreach($action as $k =>$v)
                    <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                </select>
                <input type="submit" value="Áp dụng" class="btn btn-primary">
            </div>
            <table class="table table-striped table-checkall">
                @if(session('status'))
                <div class="alert alert-success">
                    {{session('status')}}
                </div>
            @elseif(session('error'))
            <div class="alert alert-danger">
                {{session('error')}}
            </div>    
            @elseif(session('warning'))
            <div class="alert alert-warning">
                {{session('warning')}}
            </div>    
            @else
            @endif
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="checkall">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Mã</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Giá trị</th>
                        {{-- <th scope="col">Trạng thái</th> --}}
                        <th scope="col">Thời gian</th>
                        <th scope="col">Tác vụ</th>
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
                        <td>
                            <input type="checkbox" name="list-check[]" value="{{$order->id}}">
                        </td>
                        <td>{{$index}}</td>
                        <td>#{{$order->user_id}}{{$order->id}}</td>
                        <td>{{$order->name_user}}</td>
                        <td><a href="{{route('detail', $order->product_id)}}">{{$order->name_product}}</a></td>
                        <td>{{$order->num_order}}</td>
                        <td>{{number_format($order->num_order*$order->price,0,",",".")}}đ</td>
                        {{-- <td><span class="badge badge-warning">Đang xử lý</span></td> --}}
                        <td>{{$order->created_at}}</td>
                        <td>
                            {{-- <a href="{{route('product_edit',$product->id)}}" onclick="return confirm('Bạn có chắc muốn chỉnh sửa bản ghi này?')" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a> --}}
                            <a href="{{route('order_delete',$order->id)}}" onclick="return confirm('Bạn có chắc muốn xóa bản ghi này?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @endif
                    {{-- <tr>
                        <td>
                            <input type="checkbox">
                        </td>
                        <td>2</td>
                        <td>1213</td>
                        <td>
                            Minh Anh <br>
                            0868873382
                        </td>
                        <td><a href="#">Samsung Galaxy A51 (8GB/128GB)</a></td>
                        <td>1</td>
                        <td>7.790.000₫</td>
                        <td><span class="badge badge-success">Hoàn thành</span></td>
                        <td>26:06:2020 14:00</td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox">
                        </td>
                        <td>3</td>
                        <td>1214</td>
                        <td>
                            Trần Thu Hằng <br>
                            0234343545
                        </td>
                        <td><a href="#">Điện thoại iPhone 11 Pro Max 64GB</a></td>
                        <td>1</td>
                        <td>29.490.000₫</td>
                        <td><span class="badge badge-success">Hoàn thành</span></td>
                        <td>26:06:2020 14:00</td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox">
                        </td>
                        <td>4</td>
                        <td>1212</td>
                        <td>
                            Tuấn Anh <br>
                            091236768
                        </td>
                        <td><a href="#">Apple MacBook Pro Touch 2020 i5 512GB</a></td>
                        <td>1</td>
                        <td>47.990.000₫</td>
                        <td><span class="badge badge-warning">Đang xử lý</span></td>
                        <td>26:06:2020 14:00</td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox">
                        </td>
                        <td>5</td>
                        <td>1214</td>
                        <td>
                            Trần Thu Hằng <br>
                            0234343545
                        </td>
                        <td><a href="#">Điện thoại iPhone 11 Pro Max 64GB</a></td>
                        <td>1</td>
                        <td>29.490.000₫</td>
                        <td><span class="badge badge-success">Hoàn thành</span></td>
                        <td>26:06:2020 14:00</td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox">
                        </td>
                        <td>6</td>
                        <td>1212</td>
                        <td>
                            Tuấn Anh <br>
                            091236768
                        </td>
                        <td><a href="#">Apple MacBook Pro Touch 2020 i5 512GB</a></td>
                        <td>1</td>
                        <td>47.990.000₫</td>
                        <td><span class="badge badge-success">Hoàn thành</span></td>
                        <td>26:06:2020 14:00</td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr> --}}
            </table>
        </form>
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