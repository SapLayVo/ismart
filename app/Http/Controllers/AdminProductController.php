<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Str;
class AdminProductController extends Controller
{
    public function __construct()
    {

        $this->middleware('checkRole');

        function utf8convert($str) {
            if(!$str) return false;
            $utf8 = array(
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

        'd'=>'đ|Đ',

        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

        'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',

        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

        'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
                                            );
            foreach($utf8 as $ascii=>$uni) $str = preg_replace("/($uni)/i",$ascii,$str);
            $str=Str::lower($str);
            return $str;    
            }
    }

    function list(request $request){
        
        $category=$request->input('category');
        if($category == 1){
            session(['category'=>1]);
            $products=Product::where('category',1);
        }elseif($category == 2){
            session(['category'=>2]);
            $products=Product::where('category',2);
        }
        else{
            $products=Product::select();
            $request->session()->forget('category');
        }

        $num_per_page=5;

        
        if($request->input('keyword')){
            $keyword=$request->input('keyword');
            $products=$products->where('name','LIKE',"%{$keyword}%")->paginate();
        }else{
            $products=$products->paginate($num_per_page);
        }

        if(session('category')){
            $products=$products->appends(['category'=> session('category')]);
        }


        $count_category1=Product::where('category',1)->count();
        $count_category2=Product::where('category',2)->count();

        return view('admin.product.list',compact('products','count_category1','count_category2','num_per_page'));
    }


    function add(){
        return view('admin.product.add');
    }

    function create(request $request){
        $request->validate([
            'name'=> 'required|string|max:255',
            'content'=> 'required|string',
            'product_img' =>'required|string',
            'price'=>'required',
            'category'=>'required',
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
            'name'=>'Tên sản phẩm',
            'content'=>'Mô tả',
            'product_img'=>'Đường dẫn',
            'price'=>'Giá',
            'category'=>'Danh mục',
        
        ]);
        
    
    Product::create([
        'name' => $request->input('name'),
        'content' => $request->input('content'),
        'content_not_mark' => utf8convert($request->input('content')),
        'price' => $request->input('price'), 
        'product_img' => $request->input('product_img'),
        'category' => $request->input('category'),
        'discount' => $request->input('discount'),
        'country' => $request->input('country'),
        'trademark'=> $request->input('trademark'),
    ]);
        return redirect('admin/product/list')->with('status','Thêm thành viên thành công');
    }

    function option(request $request){
        $check = $request->input('list-check');
        if($request->input('list-check')){
            $action=$request->input('action');
            if($action=="delete"){
                Product::destroy($check);
                return redirect('admin/product/list')->with('status','Đã xóa bản ghi thành công');
            }else{
                return redirect('admin/product/list')->with('warning','Bạn chưa có lựa chọn thích hợp');
            }
        }else{
            return redirect('admin/product/list')->with('warning','Bạn cần chọn phần tử để thực thi');
        }
    }

    function delete($id){
        Product::find($id)->delete();
        return redirect('admin/product/list')->with('status','Đã xóa bản ghi thành công');
    }

    function edit($id){
        $product=Product::find($id);
        return view('admin.product.edit',compact('product'));

    }

    function update(request $request,$id){
        $request->validate([
            'name'=> 'required|string|max:255',
            'content'=> 'required|string',
            'product_img' =>'required|string',
            'price'=>'required',
            'category'=>'required',
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
            'name'=>'Tên sản phẩm',
            'content'=>'Mô tả',
            'product_img'=>'Đường dẫn',
            'price'=>'Giá',
            'category'=>'Danh mục',
        
        ]);

        $product=Product::where('id',$id)->update([
            'name'=> $request->input('name'),
            'content' => $request->input('content'),
            'content_not_mark' => utf8convert($request->input('content')),
            'price' => $request->input('price'), 
            'product_img' => $request->input('product_img'),
            'category' => $request->input('category'),
            'discount' => $request->input('discount'),
            'country' => $request->input('country'),
            'trademark'=> $request->input('trademark'),
        ]);

        return redirect('admin/product/list')->with('status','Cập nhật dữ liệu thành công');

    }
}
