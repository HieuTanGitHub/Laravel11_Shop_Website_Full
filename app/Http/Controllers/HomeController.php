<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Mail;
use App\Models\CatePost;
use App\Models\CategoryProductModel;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Icons;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

session_start();

class HomeController extends Controller
{
    public function error_page()
    {
        return view('errors.404');
    }
    public function load_more_product(Request $request)
    {

        $data = $request->all();

        if ($data['id'] > 0) {
            $all_product = Product::where('product_status', '0')->where('product_id', '<', $data['id'])->orderby('product_id', 'DESC')->take(6)->get();
        } else {
            $all_product = Product::where('product_status', '0')->orderby('product_id', 'DESC')->take(6)->get();
        }

        $output = '';
        if (!$all_product->isEmpty()) {
            foreach ($all_product as $key => $pro) {
                $last_id = $pro->product_id;
                $output .= '<div class="col-sm-4">
                <div class="product-image-wrapper">

                <div class="single-products">
                <div class="productinfo text-center">


                <input type="hidden" value="' . $pro->product_id . '" class="cart_product_id_' . $pro->product_id . '">

                <input type="hidden" id="wishlist_productname' . $pro->product_id . '" value="' . $pro->product_name . '" class="cart_product_name_' . $pro->product_id . '">

                <input type="hidden" value="' . $pro->product_quantity . '" class="cart_product_quantity_' . $pro->product_id . '">

                <input type="hidden" value="' . $pro->product_image . '" class="cart_product_image_' . $pro->product_id . '">

                <input type="hidden" id="wishlist_productprice' . $pro->product_id . '" value="' . number_format($pro->product_price, 0, ',', '.') . 'VNĐ">


                <input type="hidden" value="' . $pro->product_price . '" class="cart_product_price_' . $pro->product_id . '">

                <input type="hidden" value="1" class="cart_product_qty_' . $pro->product_id . '">

                <a id="wishlist_producturl' . $pro->product_id . '"  href="' . url('chi-tiet/' . $pro->product_slug) . '">


                <img id="wishlist_productimage' . $pro->product_id . '" src="' . url('uploads/product/' . $pro->product_image) . '" alt="' . $pro->product_name . '" />

                <h2>' . number_format($pro->product_price, 0, ',', '.') . 'VNĐ</h2>
                <p>' . $pro->product_name . '</p>

                </a>


                <button class="btn btn-default home_cart_' . $pro->product_id . '" id="' . $pro->product_id . '" onclick="Addtocart(this.id);"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>

                <button style="display:none" class="btn btn-danger rm_home_cart_' . $pro->product_id . '" id="' . $pro->product_id . '" onclick="Deletecart(this.id);"><i class="fa fa-shopping-cart"></i>Bỏ đã thêm</button>


                <input type="button" data-toggle="modal" data-target="#xemnhanh" onclick="XemNhanh(this.id);"  value="Xem nhanh"  class="btn btn-default" id="' . $pro->product_id . '" name="add-to-cart">

                </div>

                </div>

                <div class="choose">
                <ul class="nav nav-pills nav-justified">


                <li>  

                <i class="fa fa-plus-square"></i>

                <button class="button_wishlist" id="' . $pro->product_id . '" onclick="add_wistlist(this.id);"><span>Yêu thích</span></button>

                </li>

                <li ><a style="cursor: pointer;" onclick="add_compare(' . $pro->product_id . ')" ><i class="fa fa-plus-square"></i>So sánh</a></li>

                </ul>
                </div>
                </div>
                </div>';
            }
            $output .= '
                <div id="load_more">
                    <button type="button" name="load_more_button" class="btn btn-primary form-control" data-id="' . $last_id . '" id="load_more_button">Load thêm sản phẩm
                    </button>
                </div>
            ';
        } else {
            $output .= '
                <div id="load_more">
                    <button type="button" name="load_more_button" class="btn btn-default form-control">Dữ liệu đang cập nhật thêm...
                    </button>
                </div>
            ';
        }
        echo $output;
    }
    public function index(Request $request)
    {
        //get icons social
        $icons = Icons::orderBy('id_icons', 'DESC')->get();
        //category post
        $category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();

        //slide
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        //seo 
        $meta_desc = "Chuyên bán những phụ kiện ,thiết bị game";
        $meta_keywords = "thiet bi game,phu kien game,game phu kien,game giai tri";
        $meta_title = "Phụ kiện,máy chơi game chính hãng";
        $url_canonical = $request->url();
        //--seo

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_parent', 'desc')->orderby('category_order', 'ASC')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();


        $all_product = DB::table('tbl_product')->where('product_status', '0')->orderby(DB::raw('RAND()'))->paginate(6);

        $cate_pro_tabs = CategoryProductModel::where('category_parent', 0)->orderBy('category_id', 'DESC')->get();

        return view('pages.home')->with('category', $cate_product)->with('brand', $brand_product)->with('all_product', $all_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('slider', $slider)->with('category_post', $category_post)->with('cate_pro_tabs', $cate_pro_tabs)->with('icons', $icons); //1
        // return view('pages.home')->with(compact('cate_product','brand_product','all_product')); //2
    }
    public function yeu_thich(Request $request)
    {
        //category post
        $category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();

        //slide
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        //seo 
        $meta_desc = "Yêu thích";
        $meta_keywords = "Yêu thích";
        $meta_title = "Yêu thích";
        $url_canonical = $request->url();
        //--seo

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_parent', 'desc')->orderby('category_order', 'ASC')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        // $all_product = DB::table('tbl_product')
        // ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        // ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        // ->orderby('tbl_product.product_id','desc')->get();

        $all_product = DB::table('tbl_product')->where('product_status', '0')->orderby(DB::raw('RAND()'))->paginate(6);

        return view('pages.yeuthich.yeuthich')->with('category', $cate_product)->with('brand', $brand_product)->with('all_product', $all_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('slider', $slider)->with('category_post', $category_post); //1

    }
    public function search(Request $request)
    {
        //category post
        $category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();
        //slide
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();

        //seo 
        $meta_desc = "Tìm kiếm sản phẩm";
        $meta_keywords = "Tìm kiếm sản phẩm";
        $meta_title = "Tìm kiếm sản phẩm";
        $url_canonical = $request->url();
        //--seo
        $keywords = $request->keywords_submit;

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%' . $keywords . '%')->get();


        return view('pages.sanpham.search')->with('category', $cate_product)->with('brand', $brand_product)->with('search_product', $search_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('slider', $slider)->with('category_post', $category_post);
    }

    public function autocomplete_ajax(Request $request)
    {
        $data = $request->all();

        if ($data['query']) {

            $product = Product::where('product_status', 0)->where('product_name', 'LIKE', '%' . $data['query'] . '%')->get();

            $output = '
            <ul class="dropdown-menu" style="display:block; position:relative">';

            foreach ($product as $key => $val) {
                $output .= '
             <li class="li_search_ajax"><a href="#">' . $val->product_name . '</a></li>
             ';
            }

            $output .= '</ul>';
            echo $output;
        }
    }
}
