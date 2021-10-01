@extends('layouts.shop')

@section('content')
         <div class="app__container container-fluid">
            <div class="grid">
                <div class="grid__row app__content ">    
                    <div class="grid__column-2 hidden-sm-down col-lg-2 col-xl-2">
                        <nav class="category">
                            <h3 class="category__heading">
                                <i class="category__heading-icon fas fa-list-ul"></i>
                                Danh Mục
                            </h3>
                            <ul class="category-list">
                                
                                <li class="category-item @isset($_GET['category']) @else category-item--active @endisset">
                                    <a href="{{route('home')}}" class="category-item__link">Tât cả sản phẩm</a>
                                </li>
                                <li class="category-item @isset($_GET['category']) @if($_GET['category']==1) category-item--active @endif @endisset">
                                    <a href="{{route('home')}}?category=1" class="category-item__link">Điện thoại</a>
                                </li>
                                <li class="category-item @isset($_GET['category']) @if($_GET['category']==2) category-item--active @endif @endisset">
                                    <a href="{{route('home')}}?category=2" class="category-item__link">Laptop</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="hidden-sm-up col-sm-1 col-xs-1"></div>
                    <div class="grid__column-10 col-md-10 col-lg-10 col-sm-10 col-xs-10 ">          
                        <div class="home-filter ">
                            <span class="home-filter__label hidden-xs-down">Sắp xếp theo</span>
                            <button class="home-filter__btn btn">Phổ biến</button>
                            <button class="home-filter__btn btn btn--primary">Mới nhất</button>
                            <button class="home-filter__btn btn">Bán chạy</button>

                            <div class="select-input hidden-md-down">
                                <span class="select-input__label">Giá</span>
                                <i class="select-input__icon fas fa-angle-down"></i>
                                
                                <ul class="select-input__list">
                                    <li class="select-input__item"> 
                                        <a href="@if(isset($_GET['category']))?category={{$_GET['category']}}&price=asc @elseif(isset($_GET['search']))?search={{$_GET['search']}}&price=asc  @else?price=asc @endif" class="select-input__link">Giá: Thấp đến cao</a>
                                    </li>

                                    <li class="select-input__item">
                                        <a href="@if(isset($_GET['category']))?category={{$_GET['category']}}&price=desc @elseif(isset($_GET['search']))?search={{$_GET['search']}}&price=desc  @else?price=desc @endif" class="select-input__link">Giá: Cao đến thấp</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- demo
                            <div class="select-input">
                                <select name="select-input__price" id="">   
                                    <option value="select-input__asc">Giá: Thấp đến cao</option>
                                    <option value="select-input__desc">Giá: Cao đến thấp</option>
                                </select>
                            </div> -->
                            @if($page>0 && $num_page>0)
                            <div class="home-filter__page hidden-sm-down">
                                <span class="home-filter__page-num">
                                    <span class="home-filter__page-current">{{$page}}</span>/{{$num_page}}
                                </span>
                                
                                <div class="home-filter__page-control">
                                    <a @if($page==1) @else href="?page={{$page-1}}" @endif class="home-filter__page-btn @if($page==1)home-filter__page-btn--disabled @endif" >
                                        <i class="home-filter__page-icon fas fa-angle-left"></i>
                                    </a>
                                    <a @if($page==$num_page) @else href="?page={{$page+1}}" @endif class="home-filter__page-btn @if($page==$num_page)home-filter__page-btn--disabled @endif">
                                        <i class="home-filter__page-icon fas fa-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <div class="home-product ">
                            <!-- grid -> row -> column -->
                            <div class="grid__row row-cols-md-4 row-cols-sm-3 row-cols-lg-5 row-cols-xl-5 row-cols-xxl-5 row-cols-2">
                                @foreach($products as $product)
                                    @php
                                   $price=$product->price/1000;
                                    $price_new=ceil($price - ($price* $product ->discount/100))*1000;    
                                    @endphp
                                <div class="grid__column-2-4 ">
                                    <!-- product item -->
                                    <a href="{{route('detail', $product->id)}}" class="home-product-item">
                                         <div class="home-product-item__img" style="background-image: url({{$product->product_img}});" ></div> 
                                        <h4 class="home-product-item-name">{{$product->content}}</h4>
                                        <div class="home-product-item__price">   
                                            @if($product ->discount)
                                            <span class="home-product-item__price-old">{{number_format($product->price,0,',','.')}}đ</span>
                                            @endif
                                            <span class="home-product-item__price-current">{{number_format($price_new,0,',','.')}}đ</span>
                                        </div>
                                        <div class="home-product-item__action">
                                            <span class="home-product-item__like home-product-item__like--liked"> <!--bật tắt like bằng cách comment class home-product-item__like--liked -->
                                                <i class="home-product-item__like-icon-empty far fa-heart"></i>
                                                <i class="home-product-item__like-icon-fill fas fa-heart"></i>
                                            </span>
                                            <div class="home-product-item__rating">
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="home-product-item__sold">88 đã bán</span>
                                        </div>
                                        <div class="home-product-item__origin">
                                            <span class="home-product-item__brand">{{$product->trademark}}</span>
                                            <span class="home-product-item__origin-name">{{$product->country}}</span>
                                        </div>
                                        <div class="home-product-item__farvourite">
                                            <i class="fas fa-check"></i>
                                            <span>Yêu thích</span>
                                        </div>
                                     @if($product ->discount)
                                        <div class="home-product-item__sale-off">
                                            <div>
                                            <span class="home-product-item__sale-off-percent">
                                                {{$product ->discount}}%
                                            </span></div>
                                            <span class="home-product-item__sale-off-label">GIẢM</span>
                                        </div>
                                    @endif
                                    </a>    
                                </div>
                                @endforeach
                                 {{-- <div class="grid__column-2-4 ">
                                    <!-- product item -->
                                    <a href="#" class="home-product-item">
                                        <div class="home-product-item__img" style="background-image: url(https://cf.shopee.vn/file/ceb97b4b12cad39c74081f9000507ac6_tn);" ></div>
                                        <h4 class="home-product-item-name">Áo Khoác Len Lông Cừu Có Mũ Trùm Thời Trang Mùa Đông Cho Nam</h4>
                                        <div class="home-product-item__price">  
                                            <span class="home-product-item__price-old">1.000.000đ</span>
                                            <span class="home-product-item__price-current">999.000đ</span>
                                        </div>
                                        <div class="home-product-item__action">
                                            <span class="home-product-item__like home-product-item__like--liked"> <!--bật tắt like bằng cách comment class home-product-item__like--liked -->
                                                <i class="home-product-item__like-icon-empty far fa-heart"></i>
                                                <i class="home-product-item__like-icon-fill fas fa-heart"></i>
                                            </span>
                                            <div class="home-product-item__rating">
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="home-product-item__sold">88 đã bán</span>
                                        </div>
                                        <div class="home-product-item__origin">
                                            <span class="home-product-item__brand">Whoo</span>
                                            <span class="home-product-item__origin-name">Hàn Quốc</span>
                                        </div>
                                        <div class="home-product-item__farvourite">
                                            <i class="fas fa-check"></i>
                                            <span>Yêu thích</span>
                                        </div>
                                        <div class="home-product-item__sale-off">
                                            <span class="home-product-item__sale-off-percent">43%</span>
                                            <span class="home-product-item__sale-off-label">GIẢM</span>
                                        </div>
                                    </a>    
                                </div>
                                <div class="grid__column-2-4 ">
                                    <!-- product item -->
                                    <a href="#" class="home-product-item">
                                        <div class="home-product-item__img" style="background-image: url(https://cf.shopee.vn/file/ceb97b4b12cad39c74081f9000507ac6_tn);" ></div>
                                        <h4 class="home-product-item-name">Áo Khoác Len Lông Cừu Có Mũ Trùm Thời Trang Mùa Đông Cho Nam</h4>
                                        <div class="home-product-item__price">  
                                            <span class="home-product-item__price-old">1.000.000đ</span>
                                            <span class="home-product-item__price-current">999.000đ</span>
                                        </div>
                                        <div class="home-product-item__action">
                                            <span class="home-product-item__like home-product-item__like--liked"> <!--bật tắt like bằng cách comment class home-product-item__like--liked -->
                                                <i class="home-product-item__like-icon-empty far fa-heart"></i>
                                                <i class="home-product-item__like-icon-fill fas fa-heart"></i>
                                            </span>
                                            <div class="home-product-item__rating">
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="home-product-item__sold">88 đã bán</span>
                                        </div>
                                        <div class="home-product-item__origin">
                                            <span class="home-product-item__brand">Whoo</span>
                                            <span class="home-product-item__origin-name">Hàn Quốc</span>
                                        </div>
                                        <div class="home-product-item__farvourite">
                                            <i class="fas fa-check"></i>
                                            <span>Yêu thích</span>
                                        </div>
                                        <div class="home-product-item__sale-off">
                                            <span class="home-product-item__sale-off-percent">43%</span>
                                            <span class="home-product-item__sale-off-label">GIẢM</span>
                                        </div>
                                    </a>    
                                </div>
                                <div class="grid__column-2-4 ">
                                    <!-- product item -->
                                    <a href="#" class="home-product-item">
                                        <div class="home-product-item__img" style="background-image: url(https://cf.shopee.vn/file/ceb97b4b12cad39c74081f9000507ac6_tn);" ></div>
                                        <h4 class="home-product-item-name">Áo Khoác Len Lông Cừu Có Mũ Trùm Thời Trang Mùa Đông Cho Nam</h4>
                                        <div class="home-product-item__price">  
                                            <span class="home-product-item__price-old">1.000.000đ</span>
                                            <span class="home-product-item__price-current">999.000đ</span>
                                        </div>
                                        <div class="home-product-item__action">
                                            <span class="home-product-item__like home-product-item__like--liked"> <!--bật tắt like bằng cách comment class home-product-item__like--liked -->
                                                <i class="home-product-item__like-icon-empty far fa-heart"></i>
                                                <i class="home-product-item__like-icon-fill fas fa-heart"></i>
                                            </span>
                                            <div class="home-product-item__rating">
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="home-product-item__sold">88 đã bán</span>
                                        </div>
                                        <div class="home-product-item__origin">
                                            <span class="home-product-item__brand">Whoo</span>
                                            <span class="home-product-item__origin-name">Hàn Quốc</span>
                                        </div>
                                        <div class="home-product-item__farvourite">
                                            <i class="fas fa-check"></i>
                                            <span>Yêu thích</span>
                                        </div>
                                        <div class="home-product-item__sale-off">
                                            <span class="home-product-item__sale-off-percent">43%</span>
                                            <span class="home-product-item__sale-off-label">GIẢM</span>
                                        </div>
                                    </a>    
                                </div>
                                <div class="grid__column-2-4 ">
                                    <!-- product item -->
                                    <a href="#" class="home-product-item">
                                        <div class="home-product-item__img" style="background-image: url(https://cf.shopee.vn/file/ceb97b4b12cad39c74081f9000507ac6_tn);" ></div>
                                        <h4 class="home-product-item-name">Áo Khoác Len Lông Cừu Có Mũ Trùm Thời Trang Mùa Đông Cho Nam</h4>
                                        <div class="home-product-item__price">  
                                            <span class="home-product-item__price-old">1.000.000đ</span>
                                            <span class="home-product-item__price-current">999.000đ</span>
                                        </div>
                                        <div class="home-product-item__action">
                                            <span class="home-product-item__like home-product-item__like--liked"> <!--bật tắt like bằng cách comment class home-product-item__like--liked -->
                                                <i class="home-product-item__like-icon-empty far fa-heart"></i>
                                                <i class="home-product-item__like-icon-fill fas fa-heart"></i>
                                            </span>
                                            <div class="home-product-item__rating">
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="home-product-item__sold">88 đã bán</span>
                                        </div>
                                        <div class="home-product-item__origin">
                                            <span class="home-product-item__brand">Whoo</span>
                                            <span class="home-product-item__origin-name">Hàn Quốc</span>
                                        </div>
                                        <div class="home-product-item__farvourite">
                                            <i class="fas fa-check"></i>
                                            <span>Yêu thích</span>
                                        </div>
                                        <div class="home-product-item__sale-off">
                                            <span class="home-product-item__sale-off-percent">43%</span>
                                            <span class="home-product-item__sale-off-label">GIẢM</span>
                                        </div>
                                    </a>    
                                </div>
                                <div class="grid__column-2-4 "> 
                                    <!-- product item -->
                                    <a href="#" class="home-product-item">
                                        <div class="home-product-item__img" style="background-image: url(https://cf.shopee.vn/file/ceb97b4b12cad39c74081f9000507ac6_tn);" ></div>
                                        <h4 class="home-product-item-name">Áo Khoác Len Lông Cừu Có Mũ Trùm Thời Trang Mùa Đông Cho Nam</h4>
                                        <div class="home-product-item__price">  
                                            <span class="home-product-item__price-old">1.000.000đ</span>
                                            <span class="home-product-item__price-current">999.000đ</span>
                                        </div>
                                        <div class="home-product-item__action">
                                            <span class="home-product-item__like home-product-item__like--liked"> <!--bật tắt like bằng cách comment class home-product-item__like--liked -->
                                                <i class="home-product-item__like-icon-empty far fa-heart"></i>
                                                <i class="home-product-item__like-icon-fill fas fa-heart"></i>
                                            </span>
                                            <div class="home-product-item__rating">
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="home-product-item__sold">88 đã bán</span>
                                        </div>
                                        <div class="home-product-item__origin">
                                            <span class="home-product-item__brand">Whoo</span>
                                            <span class="home-product-item__origin-name">Hàn Quốc</span>
                                        </div>
                                        <div class="home-product-item__farvourite">
                                            <i class="fas fa-check"></i>
                                            <span>Yêu thích</span>
                                        </div>
                                        <div class="home-product-item__sale-off">
                                            <span class="home-product-item__sale-off-percent">43%</span>
                                            <span class="home-product-item__sale-off-label">GIẢM</span>
                                        </div>
                                    </a>    
                                </div>
                                <div class="grid__column-2-4">
                                    <!-- product item -->
                                    <a href="#" class="home-product-item">
                                        <div class="home-product-item__img" style="background-image: url(https://cf.shopee.vn/file/ceb97b4b12cad39c74081f9000507ac6_tn);" ></div>
                                        <h4 class="home-product-item-name">Áo Khoác Len Lông Cừu Có Mũ Trùm Thời Trang Mùa Đông Cho Nam</h4>
                                        <div class="home-product-item__price">  
                                            <span class="home-product-item__price-old">1.000.000đ</span>
                                            <span class="home-product-item__price-current">999.000đ</span>
                                        </div>
                                        <div class="home-product-item__action">
                                            <span class="home-product-item__like home-product-item__like--liked"> <!--bật tắt like bằng cách comment class home-product-item__like--liked -->
                                                <i class="home-product-item__like-icon-empty far fa-heart"></i>
                                                <i class="home-product-item__like-icon-fill fas fa-heart"></i>
                                            </span>
                                            <div class="home-product-item__rating">
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="home-product-item__sold">88 đã bán</span>
                                        </div>
                                        <div class="home-product-item__origin">
                                            <span class="home-product-item__brand">Whoo</span>
                                            <span class="home-product-item__origin-name">Hàn Quốc</span>
                                        </div>
                                        <div class="home-product-item__farvourite">
                                            <i class="fas fa-check"></i>
                                            <span>Yêu thích</span>
                                        </div>
                                        <div class="home-product-item__sale-off">
                                            <span class="home-product-item__sale-off-percent">43%</span>
                                            <span class="home-product-item__sale-off-label">GIẢM</span>
                                        </div>
                                    </a>    
                                </div>
                                <div class="grid__column-2-4">
                                    <!-- product item -->
                                    <a href="#" class="home-product-item">
                                        <div class="home-product-item__img" style="background-image: url(https://cf.shopee.vn/file/ceb97b4b12cad39c74081f9000507ac6_tn);" ></div>
                                        <h4 class="home-product-item-name">Áo Khoác Len Lông Cừu Có Mũ Trùm Thời Trang Mùa Đông Cho Nam</h4>
                                        <div class="home-product-item__price">  
                                            <span class="home-product-item__price-old">1.000.000đ</span>
                                            <span class="home-product-item__price-current">999.000đ</span>
                                        </div>
                                        <div class="home-product-item__action">
                                            <span class="home-product-item__like home-product-item__like--liked"> <!--bật tắt like bằng cách comment class home-product-item__like--liked -->
                                                <i class="home-product-item__like-icon-empty far fa-heart"></i>
                                                <i class="home-product-item__like-icon-fill fas fa-heart"></i>
                                            </span>
                                            <div class="home-product-item__rating">
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="home-product-item__sold">88 đã bán</span>
                                        </div>
                                        <div class="home-product-item__origin">
                                            <span class="home-product-item__brand">Whoo</span>
                                            <span class="home-product-item__origin-name">Hàn Quốc</span>
                                        </div>
                                        <div class="home-product-item__farvourite">
                                            <i class="fas fa-check"></i>
                                            <span>Yêu thích</span>
                                        </div>
                                        <div class="home-product-item__sale-off">
                                            <span class="home-product-item__sale-off-percent">43%</span>
                                            <span class="home-product-item__sale-off-label">GIẢM</span>
                                        </div>
                                    </a>    
                                </div>
                                <div class="grid__column-2-4">
                                    <!-- product item -->
                                    <a href="#" class="home-product-item">
                                        <div class="home-product-item__img" style="background-image: url(https://cf.shopee.vn/file/ceb97b4b12cad39c74081f9000507ac6_tn);" ></div>
                                        <h4 class="home-product-item-name">Áo Khoác Len Lông Cừu Có Mũ Trùm Thời Trang Mùa Đông Cho Nam</h4>
                                        <div class="home-product-item__price">  
                                            <span class="home-product-item__price-old">1.000.000đ</span>
                                            <span class="home-product-item__price-current">999.000đ</span>
                                        </div>
                                        <div class="home-product-item__action">
                                            <span class="home-product-item__like home-product-item__like--liked"> <!--bật tắt like bằng cách comment class home-product-item__like--liked -->
                                                <i class="home-product-item__like-icon-empty far fa-heart"></i>
                                                <i class="home-product-item__like-icon-fill fas fa-heart"></i>
                                            </span>
                                            <div class="home-product-item__rating">
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="home-product-item__sold">88 đã bán</span>
                                        </div>
                                        <div class="home-product-item__origin">
                                            <span class="home-product-item__brand">Whoo</span>
                                            <span class="home-product-item__origin-name">Hàn Quốc</span>
                                        </div>
                                        <div class="home-product-item__farvourite">
                                            <i class="fas fa-check"></i>
                                            <span>Yêu thích</span>
                                        </div>
                                        <div class="home-product-item__sale-off">
                                            <span class="home-product-item__sale-off-percent">43%</span>
                                            <span class="home-product-item__sale-off-label">GIẢM</span>
                                        </div>
                                    </a>    
                                </div>
                                <div class="grid__column-2-4">
                                    <!-- product item -->
                                    <a href="#" class="home-product-item">
                                        <div class="home-product-item__img" style="background-image: url(https://cf.shopee.vn/file/ceb97b4b12cad39c74081f9000507ac6_tn);" ></div>
                                        <h4 class="home-product-item-name">Áo Khoác Len Lông Cừu Có Mũ Trùm Thời Trang Mùa Đông Cho Nam</h4>
                                        <div class="home-product-item__price">  
                                            <span class="home-product-item__price-old">1.000.000đ</span>
                                            <span class="home-product-item__price-current">999.000đ</span>
                                        </div>
                                        <div class="home-product-item__action">
                                            <span class="home-product-item__like home-product-item__like--liked"> <!--bật tắt like bằng cách comment class home-product-item__like--liked -->
                                                <i class="home-product-item__like-icon-empty far fa-heart"></i>
                                                <i class="home-product-item__like-icon-fill fas fa-heart"></i>
                                            </span>
                                            <div class="home-product-item__rating">
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="home-product-item__sold">88 đã bán</span>
                                        </div>
                                        <div class="home-product-item__origin">
                                            <span class="home-product-item__brand">Whoo</span>
                                            <span class="home-product-item__origin-name">Hàn Quốc</span>
                                        </div>
                                        <div class="home-product-item__farvourite">
                                            <i class="fas fa-check"></i>
                                            <span>Yêu thích</span>
                                        </div>
                                        <div class="home-product-item__sale-off">
                                            <span class="home-product-item__sale-off-percent">43%</span>
                                            <span class="home-product-item__sale-off-label">GIẢM</span>
                                        </div>
                                    </a>    
                                </div>
                                <div class="grid__column-2-4">
                                    <!-- product item -->
                                    <a href="#" class="home-product-item">
                                        <div class="home-product-item__img" style="background-image: url(https://cf.shopee.vn/file/ceb97b4b12cad39c74081f9000507ac6_tn);" ></div>
                                        <h4 class="home-product-item-name">Áo Khoác Len Lông Cừu Có Mũ Trùm Thời Trang Mùa Đông Cho Nam</h4>
                                        <div class="home-product-item__price">  
                                            <span class="home-product-item__price-old">1.000.000đ</span>
                                            <span class="home-product-item__price-current">999.000đ</span>
                                        </div>
                                        <div class="home-product-item__action">
                                            <span class="home-product-item__like home-product-item__like--liked"> <!--bật tắt like bằng cách comment class home-product-item__like--liked -->
                                                <i class="home-product-item__like-icon-empty far fa-heart"></i>
                                                <i class="home-product-item__like-icon-fill fas fa-heart"></i>
                                            </span>
                                            <div class="home-product-item__rating">
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="home-product-item__sold">88 đã bán</span>
                                        </div>
                                        <div class="home-product-item__origin">
                                            <span class="home-product-item__brand">Whoo</span>
                                            <span class="home-product-item__origin-name">Hàn Quốc</span>
                                        </div>
                                        <div class="home-product-item__farvourite">
                                            <i class="fas fa-check"></i>
                                            <span>Yêu thích</span>
                                        </div>
                                        <div class="home-product-item__sale-off">
                                            <span class="home-product-item__sale-off-percent">43%</span>
                                            <span class="home-product-item__sale-off-label">GIẢM</span>
                                        </div>
                                    </a>    
                                </div>
                                <div class="grid__column-2-4"> 
                                    <!-- product item -->
                                    <a href="#" class="home-product-item">
                                        <div class="home-product-item__img" style="background-image: url(https://cf.shopee.vn/file/ceb97b4b12cad39c74081f9000507ac6_tn);" ></div>
                                        <h4 class="home-product-item-name">Áo Khoác Len Lông Cừu Có Mũ Trùm Thời Trang Mùa Đông Cho Nam</h4>
                                        <div class="home-product-item__price">  
                                            <span class="home-product-item__price-old">1.000.000đ</span>
                                            <span class="home-product-item__price-current">999.000đ</span>
                                        </div>
                                        <div class="home-product-item__action">
                                            <span class="home-product-item__like home-product-item__like--liked"> <!--bật tắt like bằng cách comment class home-product-item__like--liked -->
                                                <i class="home-product-item__like-icon-empty far fa-heart"></i>
                                                <i class="home-product-item__like-icon-fill fas fa-heart"></i>
                                            </span>
                                            <div class="home-product-item__rating">
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="home-product-item__star--gold fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="home-product-item__sold">88 đã bán</span>
                                        </div>
                                        <div class="home-product-item__origin">
                                            <span class="home-product-item__brand">Whoo</span>
                                            <span class="home-product-item__origin-name">Hàn Quốc</span>
                                        </div>
                                        <div class="home-product-item__farvourite">
                                            <i class="fas fa-check"></i>
                                            <span>Yêu thích</span>
                                        </div>
                                        <div class="home-product-item__sale-off">
                                            <span class="home-product-item__sale-off-percent">43%</span>
                                            <span class="home-product-item__sale-off-label">GIẢM</span>
                                        </div>
                                    </a>    
                                </div> --}}

                            </div>
                        </div>
                        
                        <!-- thanh phan trang -->
                        <ul class="pagination home-product__pagination">
                        @if($page>1)
                            <li class="pagination-item">
                                <a href="@if(isset($_GET['category'])&& isset($_GET['price']) ) ?category={{$_GET['category']}}&price={{$_GET['price']}}&page={{$page-1}} @elseif(isset($_GET['category'])) ?category={{$_GET['category']}}&page={{$page-1}} @elseif(isset($_GET['search']) && isset($_GET['price']))?search={{$_GET['search']}}&price={{$_GET['price']}}&page={{$page-1}} @elseif(isset($_GET['search']))?search={{$_GET['search']}}&page={{$page-1}} @elseif(isset($_GET['price'])) ?price={{$_GET['price']}}&page={{$page-1}} @else ?page={{$page-1}} @endif" class="pagination-item__link">
                                    <i class="pagination-item__icon fas fa-angle-left"></i>
                                </a>
                            </li>
                        @endif
                        @for( $i=1;$i<=$num_page;$i++)
                            @if($page==$i)
                                <li class="pagination-item pagination-item--active">
                                    <a href="@if(isset($_GET['category'])&& isset($_GET['price']) ) ?category={{$_GET['category']}}&price={{$_GET['price']}}&page={{$i}} @elseif(isset($_GET['category'])) ?category={{$_GET['category']}}&page={{$i}} @elseif(isset($_GET['search']) && isset($_GET['price']))?search={{$_GET['search']}}&price={{$_GET['price']}}&page={{$i}} @elseif(isset($_GET['search']))?search={{$_GET['search']}}&page={{$i}} @elseif(isset($_GET['price'])) ?price={{$_GET['price']}}&page={{$i}} @else ?page={{$i}} @endif" class="pagination-item__link">{{$i}}</a>
                                </li>
                                
                            @else
                                <li class="pagination-item">
                                    <a href="@if(isset($_GET['category'])&& isset($_GET['price']) ) ?category={{$_GET['category']}}&price={{$_GET['price']}}&page={{$i}} @elseif(isset($_GET['category'])) ?category={{$_GET['category']}}&page={{$i}} @elseif(isset($_GET['search']) && isset($_GET['price']))?search={{$_GET['search']}}&price={{$_GET['price']}}&page={{$i}} @elseif(isset($_GET['search']))?search={{$_GET['search']}}&page={{$i}} @elseif(isset($_GET['price'])) ?price={{$_GET['price']}}&page={{$i}} @else ?page={{$i}} @endif" class="pagination-item__link">{{$i}}</a>
                                </li>
                            @endif
                        @endfor

                            {{-- <li class="pagination-item pagination-item--active">
                                <a href="" class="pagination-item__link">1</a>
                            </li>
                            <li class="pagination-item">
                                <a href="" class="pagination-item__link">2</a>
                            </li>
                            <li class="pagination-item">
                                <a href="" class="pagination-item__link">3</a>
                            </li>
                            <li class="pagination-item">
                                <a href="" class="pagination-item__link">4</a>
                            </li>
                            <li class="pagination-item">
                                <a href="" class="pagination-item__link">5</a>
                            </li>
                            <li class="pagination-item">
                                <a href="" class="pagination-item__link">...</a>
                            </li>
                            <li class="pagination-item">
                                <a href="" class="pagination-item__link">14</a>
                            </li> --}}
                        @if($page<$num_page)    
                            <li class="pagination-item">
                                <a href="@if(isset($_GET['category'])&& isset($_GET['price']) ) ?category={{$_GET['category']}}&price={{$_GET['price']}}&page={{$page+1}} @elseif(isset($_GET['category'])) ?category={{$_GET['category']}}&page={{$page+1}} @elseif(isset($_GET['search']) && isset($_GET['price']))?search={{$_GET['search']}}&price={{$_GET['price']}}&page={{$page+1}} @elseif(isset($_GET['search']))?search={{$_GET['search']}}&page={{$page+1}} @elseif(isset($_GET['price'])) ?price={{$_GET['price']}}&page={{$page+1}} @else ?page={{$page+1}} @endif" class="pagination-item__link">
                                    <i class="pagination-item__icon fas fa-angle-right"></i>
                                </a>
                            </li>
                        @endif    
                        </ul>
                    </div>
                </div>
            </div>
         </div>
         @endsection
        <!-- Modal layout-->
    <!-- <div class="modal">
        <div class="modal__overlay">

        </div>
        <div class="modal__body"> -->
            
                <!-- register form -->
            <!-- <div class="auth-form">
                <div class="auth-form__container">
                    <div class="auth-form__header">
                        <h3 class="auth-form__heading">Đăng Ký</h3>
                        <a href="" class="auth-form__switch-link">Đăng nhập</a>
                    </div>
                    <div class="auth-form__form">
                        <div class="auth-form__group">
                            <input type="mail" class="auth-form__input" placeholder="Nhập Email" >
                        </div>
                        <div class="auth-form__group">
                            <input type="password" class="auth-form__input" placeholder="Nhập Password" >
                        </div>
                        <div class="auth-form__group">
                        <input type="mail" class="auth-form__input" placeholder="Nhập Lại Password" >  
                        </div>
                    </div>
                    <div class="auth-form__aside">
                        <p class="auth-form__policy-text">
                            Bằng việc đăng ký, Bạn đã đồng ý với Shopee về
                            <a href="" class="auth-form__policy-link">Điều khoản dịch vụ</a> &
                            <a href="" class="auth-form__policy-link">Chính sách bảo mật</a>
                        </p>
                    </div>
                    <div class="auth-form__controls">
                        <button class="btn btn--normal auth-form__controls-back">TRỞ LẠI</button>
                        <button class="btn btn--primary">ĐĂNG KÝ</button>
                    </div>
                </div>
                
                <div class="auth-form__socials">
                    <a href="" class="auth-form__socials--facebook btn btn--size-s btn--with-icon">
                        <i class=" auth-form__socials-icon fab fa-facebook-square"></i>
                        <span class="auth-form__socials-title">Kết nối với Facebook</span>
                    </a>
                    <a href="" class="auth-form__socials--google btn btn--size-s btn--with-icon">
                        <i class=" auth-form__socials-icon fab fa-google"></i>
                        <span class="auth-form__socials-title">Kết nối với Google</span>
                    </a>
                </div>
            </div> -->
            
            <!-- login form -->
            <!-- <div class="auth-form">
                <div class="auth-form__container">
                    <div class="auth-form__header">
                        <h3 class="auth-form__heading">Đăng nhập</h3>
                        <a href="" class="auth-form__switch-link">Đăng ký</a>
                    </div>
                    <div class="auth-form__form">
                        <div class="auth-form__group">
                            <input type="mail" class="auth-form__input" placeholder="Email/Tên Đăng Nhập" >
                        </div>
                        <div class="auth-form__group">
                            <input type="password" class="auth-form__input" placeholder="Password" >
                        </div>
                    </div>
                    <div class="auth-form__aside">
                        <div class="auth-form__help">
                        <a href="" class="auth-form__help-link auth-form__help-forgot">Quên mật khẩu</a>
                        <span class="auth-form__help-separate"></span>
                        <a href="" class="auth-form__help-link">Cần trợ giúp?</a>   
                        </div>
                        
                    </div>
                    <div class="auth-form__controls">
                        <button class="btn btn--normal auth-form__controls-back">TRỞ LẠI</button>
                        <button class="btn btn--primary">ĐĂNG NHẬP</button>
                    </div>
                </div>
                
                <div class="auth-form__socials">
                    <a href="" class="auth-form__socials--facebook btn btn--size-s btn--with-icon">
                        <i class=" auth-form__socials-icon fab fa-facebook-square"></i>
                        <span class="auth-form__socials-title">Kết nối với Facebook</span>
                    </a>
                    <a href="" class="auth-form__socials--google btn btn--size-s btn--with-icon">
                        <i class=" auth-form__socials-icon fab fa-google"></i>
                        <span class="auth-form__socials-title">Kết nối với Google</span>
                    </a>
                </div>
            </div> -->