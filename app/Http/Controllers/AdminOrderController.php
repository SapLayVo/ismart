<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class AdminOrderController extends Controller
{
    //
    public function __construct(){
        $this->middleware('checkRole');
    }
    
    function list(request $request){

        $category=$request->input('category');
        if($category == 'trash'){
            session(['category'=>'trash']);
            $action=[
                'restore'=>"Khôi phục",
                'forceDelete'=>'Xóa vĩnh viễn'
            ];
            $orders=Order::onlyTrashed();
        }else{
            session(['category'=>'active']);
            $action=[
                'delete'=>'Hủy đơn',
            ];
            $orders=Order::select();
        }

        $num_per_page=4;

        if($request->input('keyword')){
            $keyword=$request->input('keyword');
            $orders=$orders->where('name_user','LIKE',"%{$keyword}%")->paginate();
        }else{
            $orders=$orders->paginate($num_per_page);
        }

        if(session('category')){
            $orders=$orders->appends(['category'=> session('category')]);
        }

        $count_order_active= Order::count();
        $count_order_trash= Order::onlyTrashed()->count();

        return view('admin.order.list',compact('orders','num_per_page','action','count_order_active','count_order_trash'));
    }

    function delete($id){
        Order::find($id)->delete();
        return redirect('admin/order/list')->with('status','Xóa đơn hàng thành công');
    }

    function option(request $request){
        $check = $request->input('list-check');
        if($request->input('list-check')){
            $action=$request->input('action');
            if($action=="delete"){
                Order::destroy($check);
                return redirect('admin/order/list')->with('status','Đã xóa bản ghi thành công');
            }elseif($request->input('action')=='restore'){
                Order::withTrashed()->whereIn('id',$check)->restore();
                return redirect('admin/order/list?status=trash')->with('status','Khôi phục bản ghi thành công');
            }elseif($action=='forceDelete'){
                Order::onlyTrashed()->whereIn('id',$check)->forceDelete($check);
                return redirect('admin/order/list?status=trash')->with('status','Đã xóa bản ghi vĩnh viễn');
            }else{
                return redirect('admin/order/list')->with('warning','Bạn chưa có lựa chọn thích hợp');
            }
        }else{
            return redirect('admin/order/list')->with('warning','Bạn cần chọn phần tử để thực thi');
        }
    }
}
