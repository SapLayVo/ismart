<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\user;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{

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
                $users=User::onlyTrashed();
            }else{
                session(['category'=>'active']);
                $action=[
                    'delete'=>'Vô hiệu hóa',
                ];
                $users=User::select();
            }

            $num_per_page=10;
            
            if($request->input('keyword')){
                $keyword=$request->input('keyword');
                $users=$users->where('name','LIKE',"%{$keyword}%")->paginate();
            }
            else{

                $users=$users->paginate($num_per_page);
            }

            if(session('category')){
                $users->appends(['category'=> session('category')]);
            }
            $count_user_active= User::count();
            $count_user_trash= User::onlyTrashed()->count();
        return view('admin.user.list',compact('users','count_user_active','count_user_trash','action','num_per_page'));
    }

    function add(request $request){

        return view('admin.user.add');
        
    }

    function store(request $request){

        $request->validate([
            'name'=> 'required|string|max:255',
            'email'=>"required|string|email|max:255|unique:users|",
            'password'=>"required|min:8|confirmed",
        ],
        [
            'required'=>":attribute không được để trống",
            'min'=>":attribute có độ dài ít nhất :min ký tự",
            'max'=> ":attribute có độ dài không vượt quá :max ký tự",
            'email'=>'trường :attribute phải là email',
            'unique'=>':attribute này đã được sử dụng trước đó',
            'confirmed'=> "xác nhận mật khẩu không thành công"
        ],
        [
            'name'=>'Tên đăng nhập',
            'email'=>'Email',
            'password'=>'Mật khẩu',
        ]
    );
    User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
        'role_id'=> $request->input('role_id'),
    ]);
        return redirect('admin/user/list')->with('status','Thêm thành viên thành công');
    }

    function delete($id){
        if(Auth::id() !=$id){
            User::find($id)->delete();
            return redirect('admin/user/list')->with('status','Xóa thành viên thành công');
        }else{
            return redirect('admin/user/list')->with('error','Không thể tự xóa tài khoản chính mình');
        }
    }

    function option(request $request){
        $check=$request->input('list-check');
        if($request->input('list-check')){

            foreach($check as $k=>$id){
                if(Auth::id()==$id){
                    unset($check[$k]);
                }
            }

            if(!empty($check)){
                $action=$request->input('action');
                if($request->input('action')=='restore'){
                    User::withTrashed()->whereIn('id',$check)->restore();
                    return redirect('admin/user/list?category=trash')->with('status','Khôi phục bản ghi thành công');
                }

                elseif($action=='delete'){
                    User::destroy($check);
                    return redirect('admin/user/list')->with('status','Đã thêm bản ghi vào mục vô hiệu hóa');
                }

                elseif($action=='forceDelete'){
                    User::onlyTrashed()->whereIn('id',$check)->forceDelete($check);
                    return redirect('admin/user/list?category=trash')->with('status','Đã xóa bản ghi vĩnh viễn');
                }

                else{
                    return redirect('admin/user/list')->with('warning','Bạn chưa có lựa chọn thích hợp');
                }
            }else{
                return redirect('admin/user/list')->with('error','Bạn không thể tự chọn tài khoản của mình để sử dụng thao tác này');
            }
        }else{
                return redirect('admin/user/list')->with('warning','Bạn cần chọn phần tử để thực thi');
        }
    }
    function edit($id){

        $user=User::find($id);

        return view('admin.user.edit',compact('user'));
    }

    function update(request $request,$id){

        $request->validate([
            'name'=> 'required|string|max:255',
            'password'=>"required|min:8|confirmed",
        ],
        [
            'required'=>":attribute không được để trống",
            'min'=>":attribute có độ dài ít nhất :min ký tự",
            'max'=> ":attribute có độ dài không vượt quá :max ký tự",
            'unique'=>':attribute này đã được sử dụng trước đó',
            'confirmed'=> "xác nhận mật khẩu không thành công"
        ],
        [
            'name'=>'Tên đăng nhập',
            'password'=>'Mật khẩu',
        ]);

        $user=User::where('id',$id)->update([
            'name'=> $request->input('name'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect('admin/user/list')->with('status','Cập nhật dữ liệu thành công');
    }
}
