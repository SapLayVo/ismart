@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách sản phẩm</h5>
            <div class="form-search form-inline">
                <form action="" method="GET">
                    <input type="" class="form-control form-search" name="keyword" value="{{request()->input('keyword')}}" placeholder="Tìm kiếm">
                    <input type="submit" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['page'=>1,'category'=>1])}}" class="text-primary">Điện thoại<span class="text-muted">({{$count_category1}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['page'=>1,'category'=>2])}}" class="text-primary">Laptop<span class="text-muted">({{$count_category2}})</span></a>
            </div>
            <form action="{{url('admin/product/option')}}">
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" name="action" id="">
                    <option value="">Chọn</option>
                    <option value='delete'>Xóa</option>
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
                        <th scope="col">
                            <input name="checkall" type="checkbox">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Giảm giá</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                @if($products->count()>0)
                <tbody>
                    @php
                    $t=0;
                    @endphp
                    @foreach($products as $product)
                    @php
                    $t++;  
                    @endphp 
                    <tr class="">
                        <td>
                            <input type="checkbox" name="list-check[]" value="{{$product->id}}">
                        </td>
                        <td>{{$t}}</td>
                        <td><img class="item_img" src="{{$product->product_img}}" alt=""></td>
                        <td><a href="#">{{$product->name}}</a></td>
                        <td>{{number_format($product->price,0,',','.')}}₫</td>
                        <td>@if($product->category==1)Điện thoại @else Laptop @endif  </td>
                        <td>@empty($product->created_at)01:01:2021 14:00 @else {{$product->created_at}} @endempty</td>
                         <td class="item_discount"><span {{--class="badge badge-success"--}}>@empty($product->discount) @else {{$product->discount}}% @endempty </span></td> 
                        <td>
                            <a href="{{route('product_edit',$product->id)}}" onclick="return confirm('Bạn có chắc muốn chỉnh sửa bản ghi này?')" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="{{route('product_delete',$product->id)}}" onclick="return confirm('Bạn có chắc muốn xóa bản ghi này?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                   
                </tbody>  
                @else
                <p class="alert alert-primary">Không tìm thấy bản ghi nào</p>
                @endif
            </table>
        </form>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        {{$products->links()}}
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection