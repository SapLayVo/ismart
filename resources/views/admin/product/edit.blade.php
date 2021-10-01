@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Cập nhật sản phẩm
        </div>
        <div class="card-body">
            <form action="{{route('product_update',$product->id)}}" method="post" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input class="form-control" value="{{$product->name}}" type="text" name="name" id="name">
                            @error('name')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Giá(VNĐ)</label>
                            <input class="form-control" value="{{$product->price}}" type="number" min=1000 step=1000 name="price" id="price">
                            @error('price')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="content">Mô tả sản phẩm</label>
                            <textarea name="content"  class="form-control" id="content" value="{{$product->content}}" cols="30" rows="5"></textarea>
                            @error('content')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label for="product_img">Đường dẫn hình ảnh</label>
                    <input class="form-control" value="{{$product->product_img}}" type="text" name="product_img" id="product_img">
                    @error('product_img')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="">Danh mục</label>
                    <select class="form-control" name="category" id="" name="category">
                        <option>Chọn danh mục</option>
                        <option value=1 selected="selected">Điện thoại</option>
                        <option value=2>Laptop</option>
                    </select>
                    @error('category')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-4">
                        .<div class="form-group">
                          <label for="discount">Giảm giá(%)</label>
                          <input type="number" value="{{$product->discount}}" max=100 min=0 name="discount" id="discount" class="form-control" placeholder="" aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="col-4">
                        .<div class="form-group">
                          <label for="country">Xuất xứ</label>
                          <input type="text"  id="country" name="country" value="{{$product->country}}" class="form-control" placeholder="" aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="col-4">
                        .<div class="form-group">
                          <label for="trademark">Thương hiệu</label>
                          <input type="text"  id="trademark" name="trademark" value="{{$product->trademark}}" class="form-control" placeholder="" aria-describedby="helpId">
                        </div>
                    </div>
                </div>
                {{-- <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                        <label class="form-check-label" for="exampleRadios2">
                            Công khai
                        </label>
                    </div>
                </div> --}}



                <button type="submit" name="btn_update" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>   
@endsection