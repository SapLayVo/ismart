<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $num_per_page=10;
        $page=isset($_GET['page'])?(int)$_GET['page']:1;
        $start=($page-1)*$num_per_page;

        if(isset($_GET['category'])){
            $category=$_GET['category'];
            $products=Product::where('category','=',"{$category}");
        }else{
            $products =Product::where('id','>',0);
        }

        if(isset($_GET['price'])){
            $order=$_GET['price'];
            $products=$products->orderBy('price',$order);
        }

        $count =$products->count();
        
        if($start>0){
            $products =$products->offset($start)->limit($num_per_page)->get();  
        }else{
            $products =$products->limit($num_per_page)->get(); 
        }
        
        $num_page=ceil($count/$num_per_page);
        return view('home', compact('products','num_page','page','num_page'));
        
    }

    function search(request $request){
        $num_per_page=10;
        $page=isset($_GET['page'])?(int)$_GET['page']:1;
        $start=($page-1)*$num_per_page;

        $search=$request['search'];
        $products= Product::where('name','like',"%{$search}%");

        if(isset($_GET['price'])){
            $order=$_GET['price'];
            $products=$products->orderBy('price',$order);
        }

        $count =$products->count();
        if($start>0){
            $products= $products->offset($start)->limit($num_per_page)->get();  
        }else{
            $products =$products->limit($num_per_page)->get(); 
        }
        // $products= Product::where('name','like',"%{$search}%")->get(); 
        // echo $count;
        // echo $page;
        // return view('home',compact('products'));
        $num_page=ceil($count/$num_per_page);
        return view('home', compact('products','num_page','page','num_page'));

    }

    function detail($id){
        $product =Product::find($id);
        return view('detail',compact('product'));
    }
    

}
