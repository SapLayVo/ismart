<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use App\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    function show(request $request){
        // $product_name= Product::where('name','like',"%oppo%")->get('name');      //test
        // foreach($product_name as $key=> $value){
        //     echo $key."-";
        //     echo $value['name'];
        // }
        
        // echo session('qty');
        return view('cart.show');

    }
    function add(request $request, $id){
        $qty=session('qty');
        $product =Product::find($id);
        $price=$product->price/1000;
        $price_new=ceil($price - ($price* $product ->discount/100))*1000;
        Cart::add(['id' => $product->id,
                    'name' => $product->name,
                    'qty' => isset($qty) ? $qty : '1',
                    'price' => $price_new,
                    'options' => ['img' => $product->product_img,]
                ]); 
        return redirect('/');

    }

    function remove($rowId){
        Cart::remove($rowId);
        return redirect('cart/show');
    }

    function destroy(){
        Cart::destroy();
        return redirect('cart/show');
    }

    function ajax(request $request){
        //ajax cap nhat gio hang 
        $num_order=$_POST['num_order'];   
        $id=$_POST['id'];
        $total =0;    
        // $total =$price * $num_order;    
        foreach(Cart::content() as $row){
            if($row->id == $id){
            Cart::update($row->rowId,$num_order);
            Cart::update($row->rowId,['total' => $row->total]); 
            $total = $row->total;
            }
            $total_all=Cart::total();
            $count=Cart::count();
        }     
            
        $data_php= array( 
            'total'=> number_format($total,0,",","."),
            'total_all' =>$total_all,
            'count' => $count
          );
          
          
          echo json_encode($data_php);
        //   return redirect('cart/show');
        }

    function search_ajax(){
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


        $search_value= $_POST['search_value'];
        $search_value=utf8convert($search_value);

        $product_name= Product::where('name','like',"%{$search_value}%")->get(['name','id']);
        $product_count= Product::where('name','like',"%{$search_value}%")->count(); 
        $output='';
        if($product_count>0){
            $output ="<h3 class='header__search-history-heading'>Tìm kiếm đề xuất</h3> <ul class='header__search-history-list'>";
            foreach($product_name as $key=> $value){
                if($key >=5) 
                break;
                $output.="<li class='header__search-history-item'><a href='http://localhost/Laravelpro/ismart/detail/{$value['id']}'>{$value['name']}</a></li>";
            }
            $output.="</ul>";
        }else{
            $output ="<h3 class='header__search-history-heading'>Không tìm thấy sản phẩm nào</h3>";
        }
            
        $product_id= Product::where('name','like',"%{$search_value}%")->get('id');  
        // $data_php=array(
        //     'product_count'=>$product_count,
        //     'product_name'=>$product_name,
        //     'product_id' => $product_id,
        //     'output' =>$output
        // );
        
        // echo json_encode($data_php);
        echo $output;
    }

    function ajax_detail(request $request){
        $num_order=$_POST['num_order'];
        $price=$_POST['price']; 
        $request->session()->flash('qty',$num_order);
        $total=$num_order * $price;
        $data_php=array(
            'total'=> number_format($total,0,",",".")
        );

        echo json_encode($data_php);
    }

    function buy(){
        foreach(Cart::content() as $v){
            Order::create([
                'user_id'=>Auth::id(),
                'product_id'=>$v->id,
                'name_user'=>Auth::user()->name,
                'name_product'=>$v->name,
                'price'=>$v->price,
                'num_order'=>$v->qty,
            ]);
        }
        $order=Order::where('user_id',Auth::id())->orderBy('id','desc')->limit(4)->get();
        session(['buy_success'=>$order]);
        Cart::destroy();
        return redirect('cart/show')->with('success','Mua hàng thành công!');
    }


}
