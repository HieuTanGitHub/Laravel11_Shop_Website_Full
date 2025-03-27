@extends('layout')
@section('content')
    <style>
        /* General Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        /* Breadcrumb */
        .breadcrumb {
            background: none;
            font-size: 14px;
        }

        .breadcrumb-item a {
            color: #007bff;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #6c757d;
        }

        /* Product Details */
        .product-details {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .product-information h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .product-information p {
            font-size: 14px;
            color: #666;
        }

        .product-information span {
            display: block;
            margin-top: 10px;
            font-size: 18px;
            color: #ff5733;
            font-weight: bold;
        }

        .product-information input.cart_product_qty {
            width: 60px;
            text-align: center;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        /* Add to Cart Button */
        .add-to-cart {
            background: #28a745;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .add-to-cart:hover {
            background: #218838;
        }

        /* Attribute Selection */
        .box-attribute {
            border: 2px solid #ddd;
            cursor: pointer;
            padding: 5px;
            border-radius: 5px;
            text-align: center;
            transition: 0.3s;
        }

        .box-attribute:hover,
        .box-attribute.active {
            border: 2px solid #ff9800;
            background: #f8f9fa;
        }

        .box-attribute img {
            max-width: 100%;
            border-radius: 5px;
        }

        /* Image Gallery */
        #imageGallery {
            text-align: center;
        }

        #imageGallery img {
            max-width: 100%;
            border-radius: 5px;
        }

        /* Reviews */
        #reviews {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }

        .rating li {
            display: inline-block;
            font-size: 25px;
            color: #ffcc00;
            cursor: pointer;
        }

        /* Recommended Items */
        .recommended_items {
            margin-top: 40px;
        }

        .recommended_items h2 {
            font-size: 22px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .product-related {
            background: #ffffff;
            padding: 10px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .product-related:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .product-related img {
            max-width: 100%;
            border-radius: 5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .product-details {
                padding: 15px;
            }

            .product-information h2 {
                font-size: 20px;
            }

            .product-information span {
                font-size: 16px;
            }

            .add-to-cart {
                width: 100%;
            }
        }
    </style>
    @foreach ($product_details as $key => $value)
        <input type="hidden" id="product_viewed_id" value="{{ $value->product_id }}">
        <input type="hidden" id="viewed_productname{{ $value->product_id }}" value="{{ $value->product_name }}">
        <input type="hidden" id="viewed_producturl{{ $value->product_id }}"
            value="{{ url('/chi-tiet/' . $value->product_slug) }}">

        <input type="hidden" id="viewed_productimage{{ $value->product_id }}"
            value="{{ asset('uploads/product/' . $value->product_image) }}">
        <input type="hidden" id="viewed_productprice{{ $value->product_id }}"
            value="{{ number_format($value->product_price, 0, ',', '.') }}VNĐ">
        <div class="product-details"><!--product-details-->
            <style type="text/css">
                .lSSlideOuter .lSPager.lSGallery img {
                    display: block;
                    height: 140px;
                    max-width: 100%;
                }

                li.active {
                    border: 2px solid #FE980F;
                }
            </style>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background: none;">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/danh-muc/' . $cate_slug) }}">{{ $product_cate }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $meta_title }}</li>

                    <li>
                        <div class="fb-share-button" data-href="{{ $url_canonical }}" data-layout="button"
                            data-size="small">
                            <a target="_blank" href="{{ $url_canonical }}" class="fb-xfbml-parse-ignore">Chia sẻ</a>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="col-sm-5">

                <ul id="imageGallery">
                    @if ($product_attribute->count() > 0)
                        @foreach ($product_attribute as $key => $pro_attr_gal)
                            <li class="pro_attr_image_{{ $key }}"
                                data-thumb="{{ asset('uploads/attribute/' . $pro_attr_gal->image) }}"
                                data-src="{{ asset('uploads/attribute/' . $pro_attr_gal->image) }}">
                                <img width="100%" alt="{{ $pro_attr_gal->name }}"
                                    src="{{ asset('uploads/attribute/' . $pro_attr_gal->image) }}" />
                            </li>
                        @endforeach
                    @endif
                    @foreach ($gallery as $key => $gal)
                        <li data-thumb="{{ asset('uploads/gallery/' . $gal->gallery_image) }}"
                            data-src="{{ asset('uploads/gallery/' . $gal->gallery_image) }}">
                            <img width="100%" alt="{{ $gal->gallery_name }}"
                                src="{{ asset('uploads/gallery/' . $gal->gallery_image) }}" />
                        </li>
                    @endforeach
                </ul>


            </div>
            <div class="col-sm-7">
                <style>
                    .col-md-2.box-attribute {
                        padding: 0;
                        border: 2px solid #ddd;
                        cursor: pointer;
                        margin: 0 2px;
                    }

                    .col-md-2.box-attribute:hover {
                        border: 2px dashed #FE980F;
                    }

                    .pro_attr_image_click.active {
                        background-color: #f0f0f0;
                        /* Highlight color */
                        border: 2px solid #007bff;
                        /* Border color for active */
                        cursor: pointer;
                    }
                </style>
                <div class="product-information"><!--/product-information-->
                    {{-- <img src="images/product-details/new.jpg" class="newarrival" alt="" /> --}}
                    <h2>{{ $value->product_name }}</h2>
                    <p>Mã ID: {{ $value->product_id }}</p>
                    @if ($product_attribute->count() > 0)
                        <div class="row">

                            @foreach ($product_attribute as $key => $pro_attr)
                                @php
                                    $key++;
                                @endphp
                                <div class="col-md-2 box-attribute pro_attr_image_click"
                                    data-key_image="{{ $key }}" data-id_attribute="{{ $pro_attr->id }}"
                                    data-name_attribute="{{ $pro_attr->name }}"
                                    data-price_attribute="{{ $pro_attr->price }}"
                                    data-qty_attribute="{{ $pro_attr->quantity }}"
                                    data-image_attribute="{{ $pro_attr->image }}">
                                    <p class="attr_name">{{ $pro_attr->name }}</p>
                                    <img class="img img-responsive" width="100%"
                                        src="{{ asset('/uploads/attribute/' . $pro_attr->image) }}">
                                    <p class="attr_price">{{ number_format($pro_attr->price, 0, ',', '.') }}</p>

                                </div>
                            @endforeach
                        </div>
                    @endif
                    {{-- <img src="images/product-details/rating.png" alt="" /> --}}

                    <form>

                        @csrf

                        <input type="hidden" class="cart_product_id_attribute" value="0">
                        <input type="hidden" class="product_id" value="{{ $value->product_id }}">

                        <span>
                            <input type="hidden" class="cart_price_attribute" value="{{ $value->product_price }}">

                            <span id="price_init">Giá {{ number_format($value->product_price, 0, ',', '.') }}</span>
                            <span id="price_after_click">Giá {{ number_format($value->product_price, 0, ',', '.') }}</span>

                            <label>Số lượng:</label>
                            <input name="qty" type="number" min="1" max="50" class="cart_product_qty"
                                value="1" />
                        </span>
                        <input type="button" value="Thêm giỏ hàng" class="btn btn-primary btn-sm add-to-cart"
                            name="add-to-cart">
                    </form>

                    <p><b>Tình trạng:</b> Còn hàng</p>
                    <p><b>Điều kiện:</b> Mơi 100%</p>
                    <p><b>Số lượng kho còn:</b> {{ $value->product_quantity }}</p>
                    <p><b>Thương hiệu:</b> {{ $value->brand_name }}</p>
                    <p><b>Danh mục:</b> {{ $value->category_name }}</p>
                    <style type="text/css">
                        a.tags_style {
                            margin: 3px 2px;
                            border: 1px solid;

                            height: auto;
                            background: #428bca;
                            color: #ffff;
                            padding: 0px;

                        }

                        a.tags_style:hover {
                            background: black;
                        }
                    </style>
                    <fieldset>
                        <legend>Tags</legend>

                        <p><i class="fa fa-tag"></i>
                            @php
                                $tags = $value->product_tags;
                                $tags = explode(',', $tags);

                            @endphp
                            @foreach ($tags as $tag)
                                <a href="{{ url('/tag/' . str_slug($tag)) }}" class="tags_style">{{ $tag }}</a>
                            @endforeach



                        </p>
                    </fieldset>
                    <a href=""><img src="images/product-details/share.png" class="share img-responsive"
                            alt="" /></a>
                </div><!--/product-information-->
            </div>
        </div><!--/product-details-->

        <div class="category-tab shop-details-tab"><!--category-tab-->
            <div class="col-sm-12">
                <ul class="nav nav-tabs">
                    <li><a href="#details" data-toggle="tab">Mô tả</a></li>
                    <li><a href="#companyprofile" data-toggle="tab">Chi tiết sản phẩm</a></li>

                    <li class="active"><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane " id="details">
                    <p>{!! $value->product_desc !!}</p>

                </div>

                <div class="tab-pane fade" id="companyprofile">
                    <p>{!! $value->product_content !!}</p>


                </div>

                <div class="tab-pane fade active in" id="reviews">
                    <div class="col-sm-12">
                        <ul>
                            <li><a href=""><i class="fa fa-user"></i>Admin</a></li>
                            <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                            <li><a href=""><i class="fa fa-calendar-o"></i>16.09.2020</a></li>
                        </ul>
                        <style type="text/css">
                            .style_comment {
                                border: 1px solid #ddd;
                                border-radius: 10px;
                                background: #F0F0E9;
                            }
                        </style>
                        <form>
                            @csrf
                            <input type="hidden" name="comment_product_id" class="comment_product_id"
                                value="{{ $value->product_id }}">
                            <div id="comment_show"></div>

                        </form>

                        <p><b>Viết đánh giá của bạn</b></p>

                        <!------Rating here---------->
                        <ul class="list-inline rating" title="Average Rating">
                            @for ($count = 1; $count <= 5; $count++)
                                @php
                                    if ($count <= $rating) {
                                        $color = 'color:#ffcc00;';
                                    } else {
                                        $color = 'color:#ccc;';
                                    }

                                @endphp

                                <li title="star_rating" id="{{ $value->product_id }}-{{ $count }}"
                                    data-index="{{ $count }}" data-product_id="{{ $value->product_id }}"
                                    data-rating="{{ $rating }}" class="rating"
                                    style="cursor:pointer; {{ $color }} font-size:30px;">&#9733;</li>
                            @endfor

                        </ul>
                        {{-- <ul class="list-inline"  title="Average Rating">
                                                	@for ($count = 1; $count <= 5; $count++)
                                                		@php
	                                                		if($count<=$rating){
	                                                			$color = 'color:#ffcc00;';
	                                                		}
	                                                		else {
	                                                			$color = 'color:#ccc;';
	                                                		}
	                                                	
                                                		@endphp
                                                	  <li title="đánh giá sao" 
                                                	  id="{{$value->product_id}}-{{$count}}" 
                                                	  data-index="{{$count}}"  
                                                	  data-product_id="{{$value->product_id}}" 
                                                	  data-rating="{{$rating}}" 
                                                	  class="rating" 
                                                	  style="cursor:pointer; {{$color}} font-size:30px;">
                                                	  &#9733;
                                                	</li>
                                                	@endfor
                                                </ul> --}}


                        <form action="#">
                            <span>
                                <input style="width:100%;margin-left: 0" type="text" class="comment_name"
                                    placeholder="Tên bình luận" />

                            </span>
                            <textarea name="comment" class="comment_content" placeholder="Nội dung bình luận"></textarea>
                            <div id="notify_comment"></div>

                            <button type="button" class="btn btn-default pull-right send-comment">
                                Gửi bình luận
                            </button>

                        </form>
                    </div>
                </div>

            </div>
        </div><!--/category-tab-->
    @endforeach
    <div class="recommended_items"><!--recommended_items-->
        <h2 class="title text-center">Sản phẩm liên quan</h2>

        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    @foreach ($relate as $key => $lienquan)
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center product-related">
                                        <img src="{{ URL::to('uploads/product/' . $lienquan->product_image) }}"
                                            alt="" />
                                        <h2>{{ number_format($lienquan->product_price, 0, ',', '.') . ' ' . 'VNĐ' }}</h2>
                                        <p>{{ $lienquan->product_name }}</p>

                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>

            </div>

        </div>
    </div><!--/recommended_items-->
    {{--   <ul class="pagination pagination-sm m-t-none m-b-none">
                       {!!$relate->links()!!}
                      </ul> --}}
@endsection
