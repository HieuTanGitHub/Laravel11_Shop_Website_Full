<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!---------Seo--------->
    <meta name="description" content="{{ $meta_desc }}">
    <meta name="keywords" content="{{ $meta_keywords }}" />
    <meta name="robots" content="INDEX,FOLLOW" />
    <link rel="canonical" href="{{ $url_canonical }}" />
    <meta name="author" content="">

    <link rel="icon" href="{{ asset('frontend/images/logo-mail.png') }}" type="image/gif" sizes="32x32">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $meta_title }}</title>
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/price-range.css') }}" rel="stylesheet">

    <link href="{{ asset('frontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/lightgallery.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/lightslider.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/prettify.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/vlite.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/owl.theme.default.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <!------------Share fb------------------>
    <meta property="og:url" content="{{ $url_canonical }}" />
    <meta property="og:type" content="articles" />
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:site_name" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_desc }}" />
    <meta property="og:image" content="{{ $share_image }}" />
    <!--//-------Seo--------->
</head><!--/head-->

<body>

    <header id="header"><!--header-->
        <div class="header_top"><!--header_top-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a href="#"><i class="fa fa-phone"></i><span style="color:red">
                                            Hotline:</span> 0932023992</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="social-icons pull-right">

                            <ul class="nav navbar-nav">
                                @foreach ($icons as $key => $ico)
                                    <li><a target="_blank" title="{{ $ico->name }}" href="{{ $ico->link }}">
                                            <img alt="{{ $ico->name }}" style="margin:4px" height="32px"
                                                width="32px" src="{{ asset('uploads/icons/' . $ico->image) }}"></a>
                                        </a></li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header_top-->

        <div class="header-middle"><!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="logo pull-left">
                            <a href="index.html"><img src="{{ 'frontend/images/home/logo.png' }}" alt="" /></a>
                        </div>
                        <div class="btn-group pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle usa"
                                    data-toggle="dropdown">
                                    Ngôn Ngữ
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('lang/vi') }}">Tiếng Việt</a></li>
                                    <li><a href="{{ url('lang/en') }}">Tiếng Anh</a></li>
                                    <li><a href="{{ url('lang/cn') }}">Tiếng Trung</a></li>
                                </ul>
                            </div>

                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle usa"
                                    data-toggle="dropdown">
                                    DOLLAR
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Canadian Dollar</a></li>
                                    <li><a href="#">Pound</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="shop-menu pull-right">

                            <ul class="nav navbar-nav">

                                <li><a href="{{ URL::to('/yeu-thich') }}"><i class="fa fa-star"></i> Yêu thích</a>
                                </li>
                                <?php
                                   $customer_id = Session::get('customer_id');
                                   $shipping_id = Session::get('shipping_id');
                                   if($customer_id!=NULL && $shipping_id==NULL){ 
                                 ?>
                                <li><a href="{{ URL::to('/checkout') }}"><i class="fa fa-crosshairs"></i> Thanh
                                        toán</a></li>

                                <?php
                                 }elseif($customer_id!=NULL && $shipping_id!=NULL){
                                 ?>
                                <li><a href="{{ URL::to('/payment') }}"><i class="fa fa-crosshairs"></i> Thanh
                                        toán</a></li>
                                <?php 
                                }else{
                                ?>
                                <li><a href="{{ URL::to('/dang-nhap') }}"><i class="fa fa-crosshairs"></i> Thanh
                                        toán</a></li>
                                <?php
                                 }
                                ?>


                                <li class="cart-hover"><a href="{{ url('gio-hang') }}"><i
                                            class="fa fa-shopping-cart"></i>
                                        Giỏ hàng

                                        <span class="show-cart"></span>

                                        <div class="clearfix"></div>

                                        <span class="giohang-hover">

                                        </span>


                                    </a>

                                </li>

                                @php
                                    $customer_id = Session::get('customer_id');
                                @endphp
                                @if ($customer_id != null)


                                    <li>
                                        <a href="{{ URL::to('history') }}"><i class="fa fa-bell"></i> Lịch sử đơn
                                            hàng </a>

                                    </li>
                                @else
                                    @if ($customer_id != null)
                                        <li>
                                            <a href="{{ URL::to('/logout-checkout') }}"><i class="fa fa-lock"></i>
                                                Đăng
                                                xuất : </a>

                                            <img width="15%" src="{{ Session::get('customer_picture') }}">
                                            {{ Session::get('customer_name') }}

                                        </li>
                                    @else
                                        <li><a href="{{ URL::to('/dang-nhap') }}"><i class="fa fa-lock"></i> Đăng
                                                nhập</a></li>
                                    @endif
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header-middle-->

        <div class="header-bottom" id="navbar"><!--header-bottom-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu pull-left">
                            <ul class="nav navbar-nav collapse navbar-collapse">

                                <li><a href="{{ URL::to('/trang-chu') }}" class="active">Trang chủ</a></li>
                                <li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach ($category as $key => $cate)
                                            @if ($cate->category_parent == 0)
                                                <li><a
                                                        href="{{ URL::to('/danh-muc/' . $cate->slug_category_product) }}">{{ $cate->category_name }}</a>
                                                </li>
                                                @foreach ($category as $key => $cate_sub)
                                                    @if ($cate_sub->category_parent == $cate->category_id)
                                                        <ul class="cate_sub">
                                                            <li><a
                                                                    href="{{ URL::to('/danh-muc/' . $cate_sub->slug_category_product) }}">{{ $cate_sub->category_name }}</a>
                                                            </li>
                                                        </ul>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>

                                <li class="dropdown"><a href="#">Blogs<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach ($category_post as $key => $danhmucbaiviet)
                                            <li><a
                                                    href="{{ URL::to('/danh-muc-bai-viet/' . $danhmucbaiviet->cate_post_slug) }}">{{ $danhmucbaiviet->cate_post_name }}</a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </li>

                                <li><a href="{{ URL::to('/gio-hang') }}">Cart

                                        <span class="show-cart"></span>

                                    </a>

                                </li>
                                {{--  <li><a href="{{URL::to('/video-shop')}}">{{__('lang.video')}}</a></li> --}}
                                <li><a href="{{ URL::to('/lien-he') }}">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <form action="{{ URL::to('/tim-kiem') }}" autocomplete="off" method="POST">
                            {{ csrf_field() }}
                            <div class="search_box">

                                <input type="text" style="width: 60%;margin-right: 5px" name="keywords_submit"
                                    id="keywords" placeholder="Tìm kiếm sản phẩm" />
                                <div id="search_ajax"></div>

                                <input type="submit" style="margin-top:0;color:#666" name="search_items"
                                    class="btn btn-primary btn-sm" value="Tìm kiếm">

                            </div>
                        </form>
                    </div>
                    <div style="clear:both;"></div>
                </div>
            </div>
        </div><!--/header-bottom-->

    </header><!--/header-->

    <!-------------------Slider Section------------------------->
    @yield('slider')
    <!-------------------Slider Attribute------------------------->
    @yield('attribute')

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 padding-right">

                    @yield('content_category')

                </div>

                @yield('sidebar')

                <div class="col-sm-9 padding-right">

                    @yield('content')

                </div>
                <style type="text/css">
                    h3.doitac {
                        text-align: center;
                        font-size: 20px;
                        text-transform: uppercase;
                        margin: 20px;
                        font-weight: bold;
                    }

                    h4.doitac_name {
                        text-align: center;
                        font-size: 13px;
                    }

                    .item img {
                        height: 100px;
                    }

                    button.owl-prev {
                        font-size: 45px !important;

                    }

                    button.owl-next {
                        font-size: 45px !important;

                    }
                </style>
                {{--   <div class="col-md-12">
                    <h3 class="doitac">Đối tác của chúng tôi</h3>
                    <div class="owl-carousel owl-theme">
                        @foreach ($icons_doitac as $key => $doitac)
                        <div class="item" style="padding-left:0 !important; ">
                            <a target="_blank" href="{{$doitac->link}}"><p><img width="100%" src="{{asset('uploads/icons/'.$doitac->image)}}"></p>
                            <h4 class="doitac_name">{{$doitac->name}}</h4></a>
                        </div>
                        @endforeach
                    </div>         
                </div> --}}

            </div>
        </div>
    </section>

    <footer id="footer"><!--Footer-->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    @foreach ($contact_footer as $key => $logo)
                        <div class="col-sm-3">
                            <div class="companyinfo">
                                <p><img width="100%" src="{{ asset('uploads/contact/' . $logo->info_logo) }}"></p>
                                <p>{{ $logo->slogan_logo }}</p>
                            </div>
                        </div>
                    @endforeach

                    <div class="col-sm-7">

                    </div>

                </div>
            </div>
        </div>

        <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Dịch vụ chúng tôi</h2>
                            <ul class="nav nav-pills nav-stacked">
                                @foreach ($post_footer as $key => $post_foot)
                                    <li><a
                                            href="{{ url('/bai-viet/' . $post_foot->post_slug) }}">{{ $post_foot->post_title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    @foreach ($contact_footer as $key => $contact_foo)
                        <div class="col-sm-3">
                            <div class="single-widget">
                                <h2>Thông tin địa chỉ shop</h2>
                                <div class="information_footer">
                                    {!! $contact_foo->info_contact !!}

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="single-widget">
                                <h2>Fanpage</h2>
                                <ul class="nav nav-pills nav-stacked">
                                    <li> {!! $contact_foo->info_fanpage !!}</li>

                                </ul>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-sm-3 col-sm-offset-1">
                        <div class="single-widget">
                            <h2>Đăng ký Email</h2>
                            <form action="#" class="searchform">
                                <input type="text" placeholder="Điền email của bạn.." />
                                <button type="submit" class="btn btn-default"><i
                                        class="fa fa-arrow-circle-o-right"></i></button>
                                <p>Shop chúng tôi có cập nhật gì mới nhất <br />thì chúng tôi sẽ nhắc bạn qua email.</p>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="pull-left">Copyright © 2021 ShopHieu.com</p>

                </div>
            </div>
        </div>


    </footer><!--/Footer-->



    <script src="{{ asset('frontend/js/jquery.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>


    <script src="{{ asset('frontend/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('frontend/js/lightgallery-all.min.js') }}"></script>
    <script src="{{ asset('frontend/js/lightslider.js') }}"></script>
    <script src="{{ asset('frontend/js/prettify.js') }}"></script>
    <script src="{{ asset('frontend/js/vlite.js') }}"></script>
    <script src="{{ asset('frontend/js/simple.money.format.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://sp.zalo.me/plugins/sdk.js"></script>

    <script src="https://www.paypalobjects.com/api/checkout.js"></script>

    <script type="text/javascript">
        function Huydonhang(id) {
            var order_code = id;
            var lydo = $('.lydohuydon').val();

            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: '{{ url('/huy-don-hang') }}',
                method: "POST",

                data: {
                    order_code: order_code,
                    lydo: lydo,
                    _token: _token
                },
                success: function(data) {
                    alert('Hủy đơn hàng thành công');
                    location.reload();
                }

            });
        }
    </script>
    <script type="text/javascript">
        load_more_product();

        cart_session();

        function cart_session() {
            $.ajax({
                url: '{{ url('/cart-session') }}',
                method: "GET",
                success: function(data) {
                    $('#cart_session').html(data);
                }

            });
        }
        htmlLoaded();

        function htmlLoaded() {

            $(window).load(function() {

                var id = [];

                $(".cart_id").each(function() {
                    id.push($(this).val());
                    //alert(id);

                });

                for (var i = 0; i < id.length; i++) {

                    $('.home_cart_' + id[i]).hide();
                    $('.rm_home_cart_' + id[i]).show();

                }

            });
        }

        function load_more_product(id = '') {
            $.ajax({
                url: '{{ url('/load-more-product') }}',
                method: "POST",

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: {
                    id: id
                },
                success: function(data) {
                    $('#load_more_button').remove();

                    $('#all_product').append(data);

                    var id = [];

                    $(".cart_id").each(function() {
                        id.push($(this).val());
                        //alert(id);

                    });

                    for (var i = 0; i < id.length; i++) {

                        $('.home_cart_' + id[i]).hide();
                        $('.rm_home_cart_' + id[i]).show();

                    }


                }

            });
        }
        $(document).on('click', '#load_more_button', function() {
            var id = $(this).data('id');
            $('#load_more_button').html('<b>Loading...</b>');
            load_more_product(id);


        })
    </script>
    <script type="text/javascript">
        // When the user scrolls the page, execute myFunction
        window.onscroll = function() {
            sticky_navbar()
        };

        // Get the navbar
        var navbar = document.getElementById("navbar");

        // Get the offset position of the navbar
        var sticky = navbar.offsetTop;

        // Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
        function sticky_navbar() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky")
            } else {
                navbar.classList.remove("sticky");
            }
        }
    </script>
    <script type="text/javascript">
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            dots: false,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        })
    </script>
    <script>
        var usd = document.getElementById("vnd_to_usd").value;
        paypal.Button.render({

            // Configure environment
            env: 'sandbox',

            client: {
                sandbox: 'AXrZz-zLToqfMr-uQpcv3efjJ03lkeRJZf1XkivTFGTvF1Ul7qBf6fZNauuByqW9jtni0wrygLUE8gkQ',
                production: 'demo_production_client_id'
            },
            // Customize button (optional)
            locale: 'en_US',
            style: {
                size: 'small',
                color: 'gold',
                shape: 'pill',
            },

            // Enable Pay Now checkout flow (optional)
            commit: true,

            // Set up a payment
            payment: function(data, actions) {
                return actions.payment.create({
                    transactions: [{
                        amount: {
                            total: `${usd}`,
                            currency: 'USD'
                        }
                    }]
                });
            },
            // Execute the payment
            onAuthorize: function(data, actions) {
                return actions.payment.execute().then(function() {
                    // Show a confirmation message to the buyer
                    window.alert('Cảm ơn bạn đã mua hàng của chúng tôi!');
                });
            }
        }, '#paypal-button');
    </script>
    <div id="fb-root"></div>

    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v6.0&appId=2339123679735877&autoLogAppEvents=1">
    </script>

    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v9.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- Your Chat Plugin code -->
    <div class="fb-customerchat" attribution=setup_tool page_id="100332251915013" theme_color="#0A7CFF"
        logged_in_greeting="Chào bạn,shop có thể giúp gì được cho bạn?"
        logged_out_greeting="Chào bạn,shop có thể giúp gì được cho bạn?">
    </div>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#slider-range").slider({
                orientation: "horizontal",
                range: true,

                min: {{ $min_price_range }},
                max: {{ $max_price_range }},

                steps: 10000,
                values: [{{ $min_price }}, {{ $max_price }}],

                slide: function(event, ui) {
                    $("#amount_start").val(ui.values[0]).simpleMoneyFormat();
                    $("#amount_end").val(ui.values[1]).simpleMoneyFormat();


                    $("#start_price").val(ui.values[0]);
                    $("#end_price").val(ui.values[1]);

                }

            });

            $("#amount_start").val($("#slider-range").slider("values", 0)).simpleMoneyFormat();
            $("#amount_end").val($("#slider-range").slider("values", 1)).simpleMoneyFormat();

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $('#sort').on('change', function() {

                var url = $(this).val();
                // alert(url);
                if (url) {
                    window.location = url;
                }
                return false;
            });

        });
    </script>
    <script type="text/javascript">
        function delete_compare(id) {

            if (localStorage.getItem('compare') != null) {

                var data = JSON.parse(localStorage.getItem('compare'));

                var index = data.findIndex(item => item.id === id);

                data.splice(index, 1);

                localStorage.setItem('compare', JSON.stringify(data));
                //remove element by id
                document.getElementById("row_compare" + id).remove();

            }
        }
        sosanh();

        function sosanh() {


            if (localStorage.getItem('compare') != null) {

                var data = JSON.parse(localStorage.getItem('compare'));


                for (i = 0; i < data.length; i++) {

                    var name = data[i].name;
                    var price = data[i].price;
                    var image = data[i].image;
                    var url = data[i].url;
                    var id = data[i].id;

                    $('#row_compare').find('tbody').append(`
                                                         <tr id="row_compare` + id + `">
                                                            <td>` + name + `</td>
                                                            <td>` + price + `</td>
                                                            <td><img width="200px" src="` + image + `"></td>
                                                            <td></td>
                                                            <td><a href="` + url + `">Xem sản phẩm</a></td>
                                                            <td><a style="cursor:pointer" onclick="delete_compare(` +
                        id + `)">Xóa so sánh</a></td>
                                                          </tr>


                `);
                }

            }

        }


        function add_compare(product_id) {

            // document.getElementById('title-compare').innerText = 'Chỉ cho phép so sánh tối đa 4 sản phẩm';

            var id = product_id;

            var name = document.getElementById('wishlist_productname' + id).value;
            // var content = document.getElementById('wishlist_productcontent'+id).value;
            var price = document.getElementById('wishlist_productprice' + id).value;
            var image = document.getElementById('wishlist_productimage' + id).src;
            var url = document.getElementById('wishlist_producturl' + id).href;

            var newItem = {
                'url': url,
                'id': id,
                'name': name,
                'price': price,
                'image': image
                // 'content':content
            }

            if (localStorage.getItem('compare') == null) {
                localStorage.setItem('compare', '[]');
            }

            var old_data = JSON.parse(localStorage.getItem('compare'));

            var matches = $.grep(old_data, function(obj) {
                return obj.id == id;
            })

            if (matches.length) {

            } else {
                if (old_data.length <= 3) {

                    old_data.push(newItem);

                    $('#row_compare').find('tbody').append(`
                                                         <tr id="row_compare` + id + `">
                                                            <td>` + newItem.name + `</td>
                                                            <td>` + newItem.price + `</td>
                                                            <td><img width="200px" src="` + newItem.image + `"></td>
                                                            <td></td>
                                                            <td><a href="` + url + `">Xem sản phẩm</a></td>
                                                            <td><a style="cursor:pointer" onclick="delete_compare(` +
                        id + `)">Xóa so sánh</a></td>
                                                          </tr>


                `);
                }


            }

            localStorage.setItem('compare', JSON.stringify(old_data));
            $('#sosanh').modal();


        }
    </script>
    <script type="text/javascript">
        function viewed() {


            if (localStorage.getItem('viewed') != null) {

                var data = JSON.parse(localStorage.getItem('viewed'));

                data.reverse();

                document.getElementById('row_viewed').style.overflow = 'scroll';
                document.getElementById('row_viewed').style.height = '500px';

                for (i = 0; i < data.length; i++) {

                    var name = data[i].name;
                    var price = data[i].price;
                    var image = data[i].image;
                    var url = data[i].url;

                    $('#row_viewed').append(
                        '<div class="row" style="margin:10px 0"><div class="col-md-4"><img width="100%" src="' + image +
                        '"></div><div class="col-md-8 info_wishlist"><p>' + name + '</p><p style="color:#FE980F">' +
                        price + '</p><a href="' + url + '">Xem ngay</a></div>');
                }

            }

        }
        viewed();
        product_viewed();

        function product_viewed() {

            var id_product = $('#product_viewed_id').val();
            if (id_product != undefined) {
                var id = id_product;
                var name = document.getElementById('viewed_productname' + id).value;
                var url = document.getElementById('viewed_producturl' + id).value;
                var price = document.getElementById('viewed_productprice' + id).value;
                var image = document.getElementById('viewed_productimage' + id).value;


                var newItem = {
                    'url': url,
                    'id': id,
                    'name': name,
                    'price': price,
                    'image': image
                }

                if (localStorage.getItem('viewed') == null) {
                    localStorage.setItem('viewed', '[]');
                }

                var old_data = JSON.parse(localStorage.getItem('viewed'));

                var matches = $.grep(old_data, function(obj) {
                    return obj.id == id;
                })

                if (matches.length) {


                } else {

                    old_data.push(newItem);

                    $('#row_viewed').append(
                        '<div class="row" style="margin:10px 0"><div class="col-md-4"><img width="100%" src="' + newItem
                        .image + '"></div><div class="col-md-8 info_wishlist"><p>' + newItem.name +
                        '</p><p style="color:#FE980F">' + newItem.price + '</p><a href="' + newItem.url +
                        '">Đặt hàng</a></div>');

                }

                localStorage.setItem('viewed', JSON.stringify(old_data));
            }





        }
    </script>
    <script type="text/javascript">
        function view() {


            if (localStorage.getItem('data') != null) {

                var data = JSON.parse(localStorage.getItem('data'));

                data.reverse();

                document.getElementById('row_wishlist').style.overflow = 'scroll';
                document.getElementById('row_wishlist').style.height = '500px';

                for (i = 0; i < data.length; i++) {

                    var name = data[i].name;
                    var price = data[i].price;
                    var image = data[i].image;
                    var url = data[i].url;

                    $('#row_wishlist').append(
                        '<div class="row" style="margin:10px 0"><div class="col-md-4"><img width="100%" src="' + image +
                        '"></div><div class="col-md-8 info_wishlist"><p>' + name + '</p><p style="color:#FE980F">' +
                        price + '</p><a href="' + url + '">Đặt hàng</a></div>');
                }

            }

        }

        view();


        function add_wistlist(clicked_id) {

            var id = clicked_id;
            var name = document.getElementById('wishlist_productname' + id).value;
            var price = document.getElementById('wishlist_productprice' + id).value;
            var image = document.getElementById('wishlist_productimage' + id).src;
            var url = document.getElementById('wishlist_producturl' + id).href;

            var newItem = {
                'url': url,
                'id': id,
                'name': name,
                'price': price,
                'image': image
            }

            if (localStorage.getItem('data') == null) {
                localStorage.setItem('data', '[]');
            }

            var old_data = JSON.parse(localStorage.getItem('data'));

            var matches = $.grep(old_data, function(obj) {
                return obj.id == id;
            })

            if (matches.length) {
                alert('Sản phẩm bạn đã yêu thích,nên không thể thêm');

            } else {

                old_data.push(newItem);

                $('#row_wishlist').append(
                    '<div class="row" style="margin:10px 0"><div class="col-md-4"><img width="100%" src="' + newItem
                    .image + '"></div><div class="col-md-8 info_wishlist"><p>' + newItem.name +
                    '</p><p style="color:#FE980F">' + newItem.price + '</p><a href="' + newItem.url +
                    '">Đặt hàng</a></div>');

            }

            localStorage.setItem('data', JSON.stringify(old_data));


        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            var cate_id = $('.tabs_pro').data('id');
            var _token = $('input[name="_token"]').val();
            //alert(cate_id);
            $.ajax({
                url: '{{ url('/product-tabs') }}',
                method: "POST",
                data: {
                    cate_id: cate_id,
                    _token: _token
                },
                success: function(data) {
                    $('#tabs_product').html(data);

                }

            });

            $('.tabs_pro').click(function() {

                var cate_id = $(this).data('id');
                // alert(cate_id);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url('/product-tabs') }}',
                    method: "POST",
                    data: {
                        cate_id: cate_id,
                        _token: _token
                    },

                    success: function(data) {
                        $('#tabs_product').html(data);
                    }

                });

            });



        });
    </script>

    <script type="text/javascript">
        function remove_background(product_id) {
            for (var count = 1; count <= 5; count++) {
                $('#' + product_id + '-' + count).css('color', '#ccc');
            }
        }
        //hover chuột đánh giá sao
        $(document).on('mouseenter', '.rating', function() {
            var index = $(this).data("index");
            var product_id = $(this).data('product_id');
            // alert(index);
            // alert(product_id);
            remove_background(product_id);
            for (var count = 1; count <= index; count++) {
                $('#' + product_id + '-' + count).css('color', '#ffcc00');
            }
        });
        //nhả chuột ko đánh giá
        $(document).on('mouseleave', '.rating', function() {
            var index = $(this).data("index");
            var product_id = $(this).data('product_id');
            var rating = $(this).data("rating");
            remove_background(product_id);
            //alert(rating);
            for (var count = 1; count <= rating; count++) {
                $('#' + product_id + '-' + count).css('color', '#ffcc00');
            }
        });

        //click đánh giá sao
        $(document).on('click', '.rating', function() {
            var index = $(this).data("index");
            var product_id = $(this).data('product_id');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ url('insert-rating') }}",
                method: "POST",
                data: {
                    index: index,
                    product_id: product_id,
                    _token: _token
                },
                success: function(data) {
                    if (data == 'done') {
                        alert("Bạn đã đánh giá " + index + " trên 5");
                    } else {
                        alert("Lỗi đánh giá");
                    }
                }
            });

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            load_comment();

            function load_comment() {
                var product_id = $('.comment_product_id').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ url('/load-comment') }}",
                    method: "POST",
                    data: {
                        product_id: product_id,
                        _token: _token
                    },
                    success: function(data) {

                        $('#comment_show').html(data);
                    }
                });
            }
            $('.send-comment').click(function() {
                var product_id = $('.comment_product_id').val();
                var comment_name = $('.comment_name').val();
                var comment_content = $('.comment_content').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ url('/send-comment') }}",
                    method: "POST",
                    data: {
                        product_id: product_id,
                        comment_name: comment_name,
                        comment_content: comment_content,
                        _token: _token
                    },
                    success: function(data) {

                        $('#notify_comment').html(
                            '<span class="text text-success">Thêm bình luận thành công, bình luận đang chờ duyệt</span>'
                        );
                        load_comment();
                        $('#notify_comment').fadeOut(9000);
                        $('.comment_name').val('');
                        $('.comment_content').val('');
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        function XemNhanh(id) {
            var product_id = id;
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ url('/quickview') }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    product_id: product_id,
                    _token: _token
                },
                success: function(data) {
                    $('#product_quickview_title').html(data.product_name);
                    $('#product_quickview_id').html(data.product_id);
                    $('#product_quickview_price').html(data.product_price);
                    $('#product_quickview_image').html(data.product_image);
                    $('#product_quickview_gallery').html(data.product_gallery);
                    $('#product_quickview_desc').html(data.product_desc);
                    $('#product_quickview_content').html(data.product_content);
                    $('#product_quickview_value').html(data.product_quickview_value);
                    $('#product_quickview_button').html(data.product_button);
                    $('#product_quickview_info').html(data.product_info);
                }
            });
        }
    </script>
    <script type="text/javascript">
        $('.xemnhanh').click(function() {
            var product_id = $(this).data('id_product');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ url('/quickview') }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    product_id: product_id,
                    _token: _token
                },
                success: function(data) {
                    $('#product_quickview_title').html(data.product_name);
                    $('#product_quickview_id').html(data.product_id);
                    $('#product_quickview_price').html(data.product_price);
                    $('#product_quickview_image').html(data.product_image);

                    $('#product_quickview_desc').html(data.product_desc);
                    $('#product_quickview_content').html(data.product_content);
                    $('#product_quickview_value').html(data.product_quickview_value);
                    $('#product_quickview_button').html(data.product_button);
                }
            });
        });
    </script>
    <script type="text/javascript">
        $('#keywords').keyup(function() {
            var query = $(this).val();

            if (query != '') {
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ url('/autocomplete-ajax') }}",
                    method: "POST",
                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function(data) {
                        $('#search_ajax').fadeIn();
                        $('#search_ajax').html(data);
                    }
                });

            } else {

                $('#search_ajax').fadeOut();
            }
        });

        $(document).on('click', '.li_search_ajax', function() {
            $('#keywords').val($(this).text());
            $('#search_ajax').fadeOut();
        });
    </script>

    {{-- <script type="text/javascript">
        $(document).ready(function() {
            $('#imageGallery').lightSlider({

                gallery: true,
                item: 1,
                loop: true,
                thumbItem: 3,
                slideMargin: 0,
                enableDrag: false,
                currentPagerPosition: 'left',
                onSliderLoad: function(el) {
                    el.lightGallery({
                        selector: '#imageGallery .lslide'
                    });
                }

            });
        });
    </script> --}}

    <script type="text/javascript">
        $(document).on('click', '.watch-video', function() {
            var video_id = $(this).attr('id');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/watch-video') }}',
                method: "POST",
                dataType: "JSON",
                data: {
                    video_id: video_id,
                    _token: _token
                },
                success: function(data) {
                    $('#video_title').html(data.video_title);
                    $('#video_link').html(data.video_link);
                    $('#video_desc').html(data.video_desc);
                    var playerYT = new vlitejs({
                        selector: '#my_yt_video',
                        options: {
                            // auto play
                            autoplay: false,

                            // enable controls
                            controls: true,

                            // enables play/pause buttons
                            playPause: true,

                            // shows progress bar
                            progressBar: true,

                            // shows time
                            time: true,

                            // shows volume control
                            volume: true,

                            // shows fullscreen button
                            fullscreen: true,

                            // path to poster image
                            poster: null,

                            // shows play button
                            bigPlay: true,

                            // hide the control bar if the user is inactive
                            autoHide: false,

                            // keeps native controls for touch devices
                            nativeControlsForTouch: false
                        },
                        onReady: (player) => {
                            // callback function here
                        }
                    });

                }

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.send_order').click(function() {
                var total_after = $('.total_after').val();
                swal({
                        title: "Xác nhận đơn hàng",
                        text: "Đơn hàng sẽ không được hoàn trả khi đặt,bạn có muốn đặt không?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Cảm ơn, Mua hàng",

                        cancelButtonText: "Đóng,chưa mua",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            var shipping_email = $('.shipping_email').val();
                            var shipping_name = $('.shipping_name').val();
                            var shipping_address = $('.shipping_address').val();
                            var shipping_phone = $('.shipping_phone').val();
                            var shipping_notes = $('.shipping_notes').val();
                            var shipping_method = $('.payment_select').val();

                            var order_fee = $('.order_fee').val();
                            var order_coupon = $('.order_coupon').val();
                            var _token = $('input[name="_token"]').val();

                            $.ajax({
                                url: '{{ url('/confirm-order') }}',
                                method: 'POST',
                                data: {
                                    shipping_email: shipping_email,
                                    shipping_name: shipping_name,
                                    shipping_address: shipping_address,
                                    shipping_phone: shipping_phone,
                                    shipping_notes: shipping_notes,
                                    _token: _token,
                                    order_fee: order_fee,
                                    order_coupon: order_coupon,
                                    shipping_method: shipping_method
                                },
                                success: function() {
                                    swal("Đơn hàng",
                                        "Đơn hàng của bạn đã được gửi thành công",
                                        "success");
                                }
                            });

                            window.setTimeout(function() {
                                window.location.href = "{{ url('/history') }}";
                            }, 3000);

                        } else {
                            swal("Đóng", "Đơn hàng chưa được gửi, làm ơn hoàn tất đơn hàng", "error");

                        }

                    });


            });
        });
    </script>
    <script type="text/javascript">
        hover_cart();
        show_cart();

        function hover_cart() {
            $.ajax({
                url: '{{ url('/hover-cart') }}',
                method: "GET",
                success: function(data) {
                    $('.giohang-hover').html(data);

                }

            });
        }

        //show cart quantity
        function show_cart() {
            $.ajax({
                url: '{{ url('/show-cart') }}',
                method: "GET",
                success: function(data) {
                    $('.show-cart').html(data);

                }

            });
        }

        function Deletecart(id) {
            var id = id;
            // alert(id);
            $.ajax({
                url: '{{ url('/remove-item') }}',
                method: "GET",
                data: {
                    id: id
                },
                success: function(data) {
                    alert('Xóa sản phẩm trong giỏ hàng thành công');

                    document.getElementsByClassName("home_cart_" + id)[0].style.display = "inline";
                    document.getElementsByClassName("rm_home_cart_" + id)[0].style.display = "none";

                    hover_cart();
                    show_cart();
                    cart_session();

                }

            });
        }
        $(document).ready(function() {

            $('.add-to-cart').click(function() {

                var id = $(this).data('id_product');
                // alert(id);
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_quantity = $('.cart_product_quantity_' + id).val();
                var cart_product_price = $('.cart_price_attribute').val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();

                if (parseInt(cart_product_qty) > parseInt(cart_product_quantity)) {
                    alert('Làm ơn đặt nhỏ hơn ' + cart_product_quantity);
                } else {

                    $.ajax({
                        url: '{{ url('/add-cart-ajax') }}',
                        method: 'POST',
                        data: {
                            cart_product_id: cart_product_id,
                            cart_product_name: cart_product_name,
                            cart_product_image: cart_product_image,
                            cart_product_price: cart_product_price,
                            cart_product_qty: cart_product_qty,
                            _token: _token,
                            cart_product_quantity: cart_product_quantity
                        },
                        success: function() {

                            swal({
                                    title: "Đã thêm sản phẩm vào giỏ hàng",
                                    text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                                    showCancelButton: true,
                                    cancelButtonText: "Xem tiếp",
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Đi đến giỏ hàng",
                                    closeOnConfirm: false
                                },
                                function() {
                                    window.location.href = "{{ url('/gio-hang') }}";
                                });

                            show_cart();
                            hover_cart();
                            cart_session();
                        }

                    });
                }


            });

        });
    </script>

    <script type="text/javascript">
        function show_quick_cart() {
            $.ajax({
                url: '{{ url('/show_quick_cart') }}',
                method: 'GET',
                success: function(data) {
                    $('#show_quick_cart').html(data);
                    $('#quick-cart').modal();
                }

            });
        }

        function DeleteItemCart($session_id) {
            var session_id = $session_id;
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/del-product') }}' + '/' + session_id,
                method: 'GET',
                data: {
                    _token: _token
                },

                success: function() {

                    $('.show_quick_cart_alert').append(
                        '<p class="text text-success">Xóa sản phẩm trong giỏ hàng thành công.</p>');
                    setTimeout(function() {
                        $('.show_quick_cart_alert').fadeOut(1000);

                    }, 1000);


                    show_quick_cart();
                }

            });
        }

        $(document).on('input', '.cart_qty_update', function() {

            var quantity = $(this).val();
            var session_id = $(this).data('session_id');

            var _token = $('input[name="_token"]').val();
            // alert(quantity);
            // alert(session_id);
            $.ajax({
                url: '{{ url('/update-quick-cart') }}',
                method: 'POST',
                data: {
                    quantity: quantity,
                    session_id: session_id,
                    _token: _token
                },

                success: function() {
                    show_quick_cart();
                }

            });
        })

        function Addtocart($product_id) {
            var id = $product_id;
            // alert(id);
            var cart_product_id = $('.cart_product_id_' + id).val();
            var cart_product_name = $('.cart_product_name_' + id).val();
            var cart_product_image = $('.cart_product_image_' + id).val();
            var cart_product_quantity = $('.cart_product_quantity_' + id).val();
            var cart_product_price = $('.cart_product_price_' + id).val();
            var cart_product_qty = $('.cart_product_qty_' + id).val();
            var _token = $('input[name="_token"]').val();

            if (parseInt(cart_product_qty) > parseInt(cart_product_quantity)) {
                alert('Làm ơn đặt nhỏ hơn ' + cart_product_quantity);
            } else {

                $.ajax({
                    url: '{{ url('/add-cart-ajax') }}',
                    method: 'POST',
                    data: {
                        cart_product_id: cart_product_id,
                        cart_product_name: cart_product_name,
                        cart_product_image: cart_product_image,
                        cart_product_price: cart_product_price,
                        cart_product_qty: cart_product_qty,
                        _token: _token,
                        cart_product_quantity: cart_product_quantity
                    },

                    success: function() {
                        show_quick_cart();
                        // swal({
                        //         title: "Đã thêm sản phẩm vào giỏ hàng",
                        //         text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                        //         showCancelButton: true,
                        //         cancelButtonText: "Xem tiếp",
                        //         confirmButtonClass: "btn-success",
                        //         confirmButtonText: "Đi đến giỏ hàng",
                        //         closeOnConfirm: false
                        //     },

                        //     function() {
                        //         window.location.href = "{{ url('/gio-hang') }}";
                        //     });

                        //     document.getElementsByClassName("home_cart_"+id)[0].style.display = "none";
                        //     document.getElementsByClassName("rm_home_cart_"+id)[0].style.display = "inline";


                        //   show_cart();
                        //   hover_cart();
                        // cart_session();
                    }

                });
            }
        }
    </script>
    <!--add to  cart quickview-->
    <script type="text/javascript">
        $(document).on('click', '.add-to-cart-quickview', function() {

            var id = $(this).data('id_product');
            var cart_product_id = $('.cart_product_id_' + id).val();
            var cart_product_name = $('.cart_product_name_' + id).val();
            var cart_product_image = $('.cart_product_image_' + id).val();
            var cart_product_quantity = $('.cart_product_quantity_' + id).val();
            var cart_product_price = $('.cart_product_price_' + id).val();
            var cart_product_qty = $('.cart_product_qty_' + id).val();
            var _token = $('input[name="_token"]').val();

            if (parseInt(cart_product_qty) > parseInt(cart_product_quantity)) {
                alert('Làm ơn đặt nhỏ hơn ' + cart_product_quantity);
            } else {

                $.ajax({
                    url: '{{ url('/add-cart-ajax') }}',
                    method: 'POST',
                    data: {
                        cart_product_id: cart_product_id,
                        cart_product_name: cart_product_name,
                        cart_product_image: cart_product_image,
                        cart_product_price: cart_product_price,
                        cart_product_qty: cart_product_qty,
                        _token: _token,
                        cart_product_quantity: cart_product_quantity
                    },
                    beforeSend: function() {
                        $("#beforesend_quickview").html(
                            "<p class='text text-primary'>Đang thêm sản phẩm vào giỏ hàng</p>");
                    },
                    success: function() {
                        $("#beforesend_quickview").html(
                            "<p class='text text-success'>Sản phẩm đã thêm vào giỏ hàng</p>");


                    }

                });
            }


        });
        $(document).on('click', '.redirect-cart', function() {
            window.location.href = "{{ url('/gio-hang') }}";
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.choose').on('change', function() {
                var action = $(this).attr('id');
                var ma_id = $(this).val();
                var _token = $('input[name="_token"]').val();
                var result = '';

                if (action == 'city') {
                    result = 'province';
                } else {
                    result = 'wards';
                }
                $.ajax({
                    url: '{{ url('/select-delivery-home') }}',
                    method: 'POST',
                    data: {
                        action: action,
                        ma_id: ma_id,
                        _token: _token
                    },
                    success: function(data) {
                        $('#' + result).html(data);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.calculate_delivery').click(function() {
                var matp = $('.city').val();
                var maqh = $('.province').val();
                var xaid = $('.wards').val();
                var _token = $('input[name="_token"]').val();
                if (matp == '' && maqh == '' && xaid == '') {
                    alert('Làm ơn chọn để tính phí vận chuyển');
                } else {
                    $.ajax({
                        url: '{{ url('/calculate-fee') }}',
                        method: 'POST',
                        data: {
                            matp: matp,
                            maqh: maqh,
                            xaid: xaid,
                            _token: _token
                        },
                        success: function() {
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
    <!-- JavaScript Code -->
    <script>
        $(document).ready(function() {
            // Initialize lightSlider
            var slider = $("#imageGallery").lightSlider({
                gallery: true,
                item: 1,
                loop: true,
                thumbItem: 3,
                slideMargin: 0,
                enableDrag: false,
                currentPagerPosition: 'left',
                onSliderLoad: function(el) {
                    el.lightGallery({
                        selector: '#imageGallery .lslide'
                    });
                }
            });

            // Function to format price
            function formatPrice(price) {
                return new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(price);
            }

            // Initialize default state
            const defaultPrice = $('.cart_price_attribute').val(); // Set default price if needed
            //$('#price_init').text('Giá ' + formatPrice(defaultPrice)); // Default price display
            $('#price_after_click').hide(); // Initially hide price_after_click
            $('.cart_price_attribute').val(defaultPrice); // Set the hidden input value to default price

            // Click event for attribute selection
            $('.pro_attr_image_click').click(function() {
                var key_image = $(this).data('key_image'); // Get the key_image value
                var newPrice = $(this).data('price_attribute'); // Get the price of the clicked attribute

                // Set the value of the hidden input
                $('.cart_price_attribute').val(newPrice); // Update the hidden input with the selected price

                // Toggle behavior: if already clicked (active), unclick it
                if ($(this).hasClass('active')) {
                    // If already active, hide price_after_click and show price_init again
                    $('#price_after_click').hide();
                    $('#price_init').show();
                    $('.cart_price_attribute').val(defaultPrice);
                    // Remove active class
                    $(this).removeClass('active');

                    // Optionally, you can also reset the slider if needed
                    slider.goToSlide(0); // Go back to the first slide
                } else {
                    // If not active, update price and show the clicked price
                    $('#price_after_click').text('Giá ' + formatPrice(newPrice)).show();
                    $('#price_init').hide(); // Hide the initial price

                    // Highlight the clicked element
                    $('.pro_attr_image_click').removeClass('active');
                    $(this).addClass('active');

                    // Remove 'active' class from all slider items
                    $('[class^="pro_attr_image_"]').removeClass('active');

                    // Add 'active' class to the corresponding slide
                    $(`.pro_attr_image_${key_image}`).addClass('active');

                    // Navigate to the corresponding slide
                    slider.goToSlide(key_image);
                }
            });
        });
    </script>






</body>

</html>
