<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use App\Models\Slider;
use App\Models\CatePost;
use App\Models\Gallery;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Attribute;
use App\Models\ProductAttribute;
use File;
use Storage;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();
class ProductController extends Controller
{
    public function AuthLogin()
    {

        // if (Session::get('login_normal')) {

        //     $admin_id = Session::get('admin_id');
        // } else {
        //     $admin_id = Auth::id();
        // }
        // if ($admin_id) {
        //     return Redirect::to('dashboard');
        // } else {
        //     return Redirect::to('admin')->send();
        // }
    }
    public function file_browser(Request $request)
    {
        $paths = glob(public_path('uploads/ckeditor/*'));

        $fileNames = array();

        foreach ($paths as $path) {
            array_push($fileNames, basename($path));
        }
        $data = array(
            'fileNames' => $fileNames
        );

        return view('admin.images.file_browser')->with($data);
    }
    public function reply_comment(Request $request)
    {
        $data = $request->all();
        $comment = new Comment();
        $comment->comment = $data['comment'];
        $comment->comment_product_id = $data['comment_product_id'];
        $comment->comment_parent_comment = $data['comment_id'];
        $comment->comment_status = 0;
        $comment->comment_name = 'HiếuStore';
        $comment->save();
    }
    public function allow_comment(Request $request)
    {
        $data = $request->all();
        $comment = Comment::find($data['comment_id']);
        $comment->comment_status = $data['comment_status'];
        $comment->save();
    }
    public function list_comment()
    {
        $comment = Comment::with('product')->where('comment_parent_comment', '=', 0)->orderBy('comment_id', 'DESC')->get();
        $comment_rep = Comment::with('product')->where('comment_parent_comment', '>', 0)->get();
        return view('admin.comment.list_comment')->with(compact('comment', 'comment_rep'));
    }
    public function send_comment(Request $request)
    {
        $product_id = $request->product_id;
        $comment_name = $request->comment_name;
        $comment_content = $request->comment_content;
        $comment = new Comment();
        $comment->comment = $comment_content;
        $comment->comment_name = $comment_name;
        $comment->comment_product_id = $product_id;
        $comment->comment_status = 1;
        $comment->comment_parent_comment = 0;
        $comment->save();
    }
    public function load_comment(Request $request)
    {
        $product_id = $request->product_id;
        $comment = Comment::where('comment_product_id', $product_id)->where('comment_parent_comment', '=', 0)->where('comment_status', 0)->get();
        $comment_rep = Comment::with('product')->where('comment_parent_comment', '>', 0)->get();
        $output = '';
        foreach ($comment as $key => $comm) {
            $output .= ' 
            <div class="row style_comment">

                                        <div class="col-md-2">
                                            <img width="100%" src="' . url('frontend/images/batman-icon.png') . '" class="img img-responsive img-thumbnail">
                                        </div>
                                        <div class="col-md-10">
                                            <p style="color:green;">@' . $comm->comment_name . '</p>
                                            <p style="color:#000;">' . $comm->comment_date . '</p>
                                            <p>' . $comm->comment . '</p>
                                        </div>
                                    </div><p></p>
                                    ';

            foreach ($comment_rep as $key => $rep_comment) {
                if ($rep_comment->comment_parent_comment == $comm->comment_id) {
                    $output .= ' <div class="row style_comment" style="margin:5px 40px;background: aquamarine;">

                                        <div class="col-md-2">
                                            <img width="80%" src="' . url('frontend/images/businessman.jpg') . '" class="img img-responsive img-thumbnail">
                                        </div>
                                        <div class="col-md-10">
                                            <p style="color:blue;">@Admin</p>
                                            <p style="color:#000;">' . $rep_comment->comment . '</p>
                                            <p></p>
                                        </div>
                                    </div><p></p>';
                }
            }
        }
        echo $output;
    }
    public function local_storage()
    {
        return view('pages.local_storage.storage');
    }

    public function quickview(Request $request)
    {

        $product_id = $request->product_id;
        $product = Product::find($product_id);

        $gallery = Gallery::where('product_id', $product_id)->get();

        $output['product_gallery'] = '';

        foreach ($gallery as $key => $gal) {
            $output['product_gallery'] .= '<p><img width="100%" src="uploads/gallery/' . $gal->gallery_image . '"></p>';
        }

        $output['product_name'] = $product->product_name;
        $output['product_id'] = $product->product_id;
        $output['product_desc'] = $product->product_desc;
        $output['product_content'] = $product->product_content;
        $output['product_price'] = number_format($product->product_price, 0, ',', '.') . 'VNĐ';
        $output['product_image'] = '<p><img width="100%" src="uploads/product/' . $product->product_image . '"></p>';

        $output['product_button'] = '<input type="button" value="Mua ngay" class="btn btn-primary btn-sm add-to-cart-quickview" id="buy_quickview" data-id_product="' . $product->product_id . '"  name="add-to-cart">';

        $output['product_quickview_value'] = '

        <input type="hidden" value="' . $product->product_id . '" class="cart_product_id_' . $product->product_id . '">
                                            
        <input type="hidden" value="' . $product->product_name . '" class="cart_product_name_' . $product->product_id . '">
                                          
        <input type="hidden" value="' . $product->product_quantity . '" class="cart_product_quantity_' . $product->product_id . '">
                                            
        <input type="hidden" value="' . $product->product_image . '" class="cart_product_image_' . $product->product_id . '">

        <input type="hidden" value="' . $product->product_price . '" class="cart_product_price_' . $product->product_id . '">

        <input type="hidden" value="1" class="cart_product_qty_' . $product->product_id . '">';

        echo json_encode($output);
    }

    public function add_product()
    {
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();


        return view('admin.add_product')->with('cate_product', $cate_product)->with('brand_product', $brand_product);
    }
    public function all_product()
    {
        $this->AuthLogin();
        $all_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->orderby('tbl_product.product_id', 'desc')->get();
        $manager_product  = view('admin.all_product')->with('all_product', $all_product);
        return view('admin_layout')->with('admin.all_product', $manager_product);
    }
    public function save_product(Request $request)
    {
        $this->AuthLogin();
        $data = array();

        $product_price = filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT);
        $price_cost = filter_var($request->price_cost, FILTER_SANITIZE_NUMBER_INT);

        $data['product_name'] = $request->product_name;
        $data['price_cost'] = $price_cost;
        $data['product_tags'] = $request->product_tags;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_slug'] = $request->product_slug;
        $data['product_price'] = $product_price;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $data['product_image'] = $request->product_status;

        $get_image = $request->file('product_image');
        $get_document = $request->file('document');

        $path = 'uploads/product/';
        $path_gallery = 'uploads/gallery/';
        $path_document = 'uploads/document/';
        //them hinh anh
        if ($get_image) {

            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            File::copy($path . $new_image, $path_gallery . $new_image);
            $data['product_image'] = $new_image;
        }
        //them document
        if ($get_document) {

            $get_name_document = $get_document->getClientOriginalName();
            $name_document = current(explode('.', $get_name_document));
            $new_document =  $name_document . rand(0, 99) . '.' . $get_document->getClientOriginalExtension();
            $get_document->move($path_document, $new_document);
            $data['product_file'] = $new_document;
        }
        $pro_id = DB::table('tbl_product')->insertGetId($data);
        $gallery = new Gallery();
        $gallery->gallery_image = $new_image;
        $gallery->gallery_name = $new_image;
        $gallery->product_id = $pro_id;
        $gallery->save();

        Session::put('message', 'Thêm sản phẩm thành công');
        return Redirect::to('add-product');
    }
    public function unactive_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 1]);
        Session::put('message', 'Không kích hoạt sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function active_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 0]);
        Session::put('message', 'Không kích hoạt sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function edit_product($product_id)
    {
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();

        $edit_product = DB::table('tbl_product')->where('product_id', $product_id)->get();

        $manager_product  = view('admin.edit_product')->with('edit_product', $edit_product)->with('cate_product', $cate_product)->with('brand_product', $brand_product);

        return view('admin_layout')->with('admin.edit_product', $manager_product);
    }
    public function update_product(Request $request, $product_id)
    {
        $this->AuthLogin();
        $data = array();
        $product_price = filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT);
        $price_cost = filter_var($request->price_cost, FILTER_SANITIZE_NUMBER_INT);

        $data['product_name'] = $request->product_name;
        $data['price_cost'] = $price_cost;
        $data['product_tags'] = $request->product_tags;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_slug'] = $request->product_slug;
        $data['product_price'] = $product_price;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;

        $get_image = $request->file('product_image');
        $get_document = $request->file('document');

        $path_document = 'uploads/document/';

        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('uploads/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
            Session::put('message', 'Cập nhật sản phẩm thành công');
            return Redirect::to('all-product');
        }
        //them document
        if ($get_document) {

            $get_name_document = $get_document->getClientOriginalName();
            $name_document = current(explode('.', $get_name_document));
            $new_document =  $name_document . rand(0, 99) . '.' . $get_document->getClientOriginalExtension();
            $get_document->move($path_document, $new_document);
            $data['product_file'] = $new_document;

            //lay file old document 
            $product = Product::find($product_id);

            if ($product->product_file) {
                unlink($path_document . $product->product_file);
            }
        }
        DB::table('tbl_product')->where('product_id', $product_id)->update($data);


        Session::put('message', 'Cập nhật sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function delete_document(Request $request)
    {
        //lay file old document 
        $path_document = 'uploads/document/';
        $product = Product::find($request->product_id);
        unlink($path_document . $product->product_file);
        $product->product_file = '';
        $product->save();
    }
    public function delete_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->delete();
        Session::put('message', 'Xóa sản phẩm thành công');
        return Redirect::to('all-product');
    }
    //End Admin Page
    public function details_product($product_slug, Request $request)
    {
        //category post
        $category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();
        //slide
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();



        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $details_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->where('tbl_product.product_slug', $product_slug)->get();

        foreach ($details_product as $key => $value) {
            $category_id = $value->category_id;
            $product_id = $value->product_id;
            $product_cate = $value->category_name;
            $cate_slug = $value->slug_category_product;
            //seo 
            $meta_desc = $value->product_desc;
            $meta_keywords = $value->product_slug;
            $meta_title = $value->product_name;
            $url_canonical = $request->url();
            $share_images = url('uploads/product/' . $value->product_image);
            //--seo
        }

        //gallery
        $gallery = Gallery::where('product_id', $product_id)->get();
        //update views 
        $product = Product::where('product_id', $product_id)->first();
        $product->product_views = $product->product_views + 1;
        $product->save();
        //product attribute
        $product_attribute = ProductAttribute::where('product_id', $product_id)->get();
        //related product
        $related_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->where('tbl_category_product.category_id', $category_id)->whereNotIn('tbl_product.product_slug', [$product_slug])->orderby(DB::raw('RAND()'))->paginate(3);

        $rating = Rating::where('product_id', $product_id)->avg('rating');
        $rating = round($rating);
        return view('pages.sanpham.show_details')
            ->with('product_attribute', $product_attribute)
            ->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('product_details', $details_product)
            ->with('relate', $related_product)
            ->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)
            ->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical)
            ->with('slider', $slider)
            ->with('category_post', $category_post)
            ->with('gallery', $gallery)
            ->with('product_cate', $product_cate)
            ->with('cate_slug', $cate_slug)
            ->with('rating', $rating)
            ->with('share_images', $share_images);
    }
    public function tag(Request $request, $product_tag)
    {

        //category post
        $category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();
        //slide
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();


        $tag = str_replace("-", " ", $product_tag);



        $pro_tag = Product::where('product_status', 0)->where('product_name', 'LIKE', '%' . $tag . '%')->orWhere('product_tags', 'LIKE', '%' . $tag . '%')->orWhere('product_slug', 'LIKE', '%' . $tag . '%')->get();



        $meta_desc = 'Tags tìm kiếm::' . $product_tag;
        $meta_keywords = 'Tags tìm kiếm:' . $product_tag;
        $meta_title = 'Tags tìm kiếm:' . $product_tag;
        $url_canonical = $request->url();



        return view('pages.sanpham.tag')->with('slider', $slider)->with('category_post', $category_post)->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('product_tag', $product_tag)->with('pro_tag', $pro_tag);
    }
    public function insert_rating(Request $request)
    {
        $data = $request->all();
        $rating = new Rating();
        $rating->product_id = $data['product_id'];
        $rating->rating = $data['index'];
        $rating->save();
        echo 'done';
    }

    public function ckeditor_image(Request $request)
    {
        if ($request->hasFile('upload')) {

            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move('uploads/ckeditor', $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('uploads/ckeditor/' . $fileName);
            $msg = 'Tải ảnh thành công';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
