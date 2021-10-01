@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 "><a href="{{url('admin/user/list')}}" class="list_title">Danh sách thành viên</a></h5>
            <div class="form-search form-inline">
                <form action="" method="GET">
                    <input type="" class="form-control form-search" name="keyword" value="{{request()->input('keyword')}}" placeholder="Tìm kiếm">
                     <input type="submit" {{--name="btn-search"--}} value="Tìm kiếm" class="btn btn-primary"> 
                </form>
            </div>
        </div>
        <div class="card-body">
            
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['page'=>1,'category'=>'active'])}}" class="text-primary">Kích hoạt<span class="text-muted">({{$count_user_active}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['page'=>1,'category'=>'trash'])}}" class="text-primary">Vô hiệu hóa<span class="text-muted">({{$count_user_trash}})</span></a>
            </div>
            <form action="{{url('admin/user/option')}}">
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" name="action" id="">
                    <option value="">Chọn</option>
                    @foreach($action as $k =>$v)
                    <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                    {{-- <option value="restore">Khôi phục</option>
                    <option value="delete">Vô hiệu hóa</option> --}}
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
                        <th scope="col">Họ tên</th>
                        <th scope="col">Email</th>
                        <th scope="col">Quyền</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                @if($users->total()>0)
                <tbody>
                    @php
                    isset($_GET['page'])?$page=$_GET['page']:$page=1;
                    $index = ($page-1)*$num_per_page;
                    @endphp
                    @foreach($users as $user)
                    @php
                    $index++;  
                    @endphp 
                    <tr>
                        <td>
                            <input type="checkbox" name="list-check[]" value="{{$user->id}}">
                        </td>
                        <th scope="row">{{$index}}</th>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>@if($user->role_id==1)Admintrator @else User @endif</td>
                        <td>{{$user->created_at}}</td>
                        <td>
                            <a href="{{route('user_edit',$user->id)}}"  onclick="return confirm('Bạn chắc chắn muốn chỉnh sửa bản ghi này?')" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            @if($user->email != Auth::user()->email)
                            <a href="{{route('user_delete',$user->id)}}" onclick="return confirm('Bạn chắc chắn muốn xóa bản ghi này?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                            @endif
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
                        {{$users->links()}}
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection