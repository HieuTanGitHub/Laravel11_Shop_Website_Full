<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\CategoryPost;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserRolesController;
use App\Http\Controllers\PayPalController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Change languge 
Route::get('lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'vi', 'cn'])) {
        abort(404);
    }
    session()->put('locale', $locale);
    return redirect()->back();
});

//Frontend 
Route::get('/', [HomeController::class, 'index']);
Route::post('/load-more-product', [HomeController::class, 'load_more_product']);

Route::get('/show_quick_cart', [CartController::class, 'show_quick_cart']);
Route::get('/trang-chu', [HomeController::class, 'index']);
Route::get('/404', [HomeController::class, 'error_page']);
Route::post('/tim-kiem', [HomeController::class, 'search']);
Route::post('/autocomplete-ajax', [HomeController::class, 'autocomplete_ajax']);
Route::post('/tim-kiem', [HomeController::class, 'search']);
Route::get('/yeu-thich', [HomeController::class, 'yeu_thich']);
//Lien he trang 

Route::get('/lien-he', [ContactController::class, 'lien_he']);
Route::get('/information', [ContactController::class, 'information']);
Route::get('/list-nut', [ContactController::class, 'list_nut']);
Route::get('/delete-icons', [ContactController::class, 'delete_icons']);

Route::get('/list-doitac', [ContactController::class, 'list_doitac']);

Route::post('/add-doitac', [ContactController::class, 'add_doitac']);
Route::post('/add-nut', [ContactController::class, 'add_nut']);
Route::post('/save-info', [ContactController::class, 'save_info']);
Route::post('/update-info/{info_id}', [ContactController::class, 'update_info']);



//Danh muc san pham trang chu
Route::get('/danh-muc/{slug_category_product}', [CategoryProduct::class, 'show_category_home']);

Route::get('/chi-tiet/{product_slug}', [ProductController::class, 'details_product']);
Route::get('/tag/{product_tag}', [ProductController::class, 'tag']);
Route::get('/comment', [ProductController::class, 'list_comment']);
Route::post('/quickview', [ProductController::class, 'quickview']);
Route::post('/load-comment', [ProductController::class, 'load_comment']);
Route::post('/send-comment', [ProductController::class, 'send_comment']);
Route::post('/allow-comment', [ProductController::class, 'allow_comment']);
Route::post('/reply-comment', [ProductController::class, 'reply_comment']);
Route::post('/insert-rating', [ProductController::class, 'insert_rating']);

Route::post('/uploads-ckeditor', [ProductController::class, 'ckeditor_image']);
Route::get('/file-browser', [ProductController::class, 'file_browser']);

//Bai viet
Route::get('/danh-muc-bai-viet/{post_slug}', [PostController::class, 'danh_muc_bai_viet']);
Route::get('/bai-viet/{post_slug}', [PostController::class, 'bai_viet']);
//Backend
//
Route::get('/admin', [AuthController::class, 'login_auth']);
Route::get('/dashboard', [AdminController::class, 'show_dashboard'])->name("show_dashboard");

Route::post('/filter-by-date', [AdminController::class, 'filter_by_date']);

Route::get('/order-date', [AdminController::class, 'order_date']);

Route::post('/days-order', [AdminController::class, 'days_order']);

Route::get('/logout', [AdminController::class, 'logout']);
Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);
Route::post('/dashboard-filter', [AdminController::class, 'dashboard_filter']);

//Category Product
Route::get('/add-category-product', [CategoryProduct::class, 'add_category_product']);
Route::get('/edit-category-product/{category_product_id}', [CategoryProduct::class, 'edit_category_product']);
Route::get('/delete-category-product/{category_product_id}', [CategoryProduct::class, 'delete_category_product']);
Route::get('/all-category-product', [CategoryProduct::class, 'all_category_product']);

Route::post('/export-csv', [CategoryProduct::class, 'export_csv']);
Route::post('/import-csv', [CategoryProduct::class, 'import_csv']);

Route::post('/arrange-category', [CategoryProduct::class, 'arrange_category']);

Route::get('/unactive-category-product/{category_product_id}', [CategoryProduct::class, 'unactive_category_product']);
Route::get('/active-category-product/{category_product_id}', [CategoryProduct::class, 'active_category_product']);

Route::post('/product-tabs', [CategoryProduct::class, 'product_tabs']);


//Login facebook
Route::get('/login-facebook', [AdminController::class, 'login_facebook']);
Route::get('/admin/callback', [AdminController::class, 'callback_facebook']);

Route::get('/login-facebook-customer', [AdminController::class, 'login_facebook_customer']);
Route::get('/customer/facebook/callback', [AdminController::class, 'callback_facebook_customer']);

//Login google
Route::get('/login-google', [AdminController::class, 'login_google']);
Route::get('/google/callback', [AdminController::class, 'callback_google']);

//login customer by google
Route::get('/login-customer-google', [AdminController::class, 'login_customer_google']);
Route::get('/customer/google/callback', [AdminController::class, 'callback_customer_google']);


Route::post('/save-category-product', [CategoryProduct::class, 'save_category_product']);
Route::post('/update-category-product/{category_product_id}', [CategoryProduct::class, 'update_category_product']);

//Category Post

Route::get('/add-category-post', [CategoryPost::class, 'add_category_post']);
Route::get('/all-category-post', [CategoryPost::class, 'all_category_post']);
Route::get('/edit-category-post/{category_post_id}', [CategoryPost::class, 'edit_category_post']);

Route::post('/save-category-post', [CategoryPost::class, 'save_category_post']);
Route::post('/update-category-post/{cate_id}', [CategoryPost::class, 'update_category_post']);
Route::get('/delete-category-post/{cate_id}', [CategoryPost::class, 'delete_category_post']);
//POst

Route::get('/add-post', [PostController::class, 'add_post']);
Route::get('/all-post', [PostController::class, 'all_post']);
Route::get('/delete-post/{post_id}', [PostController::class, 'delete_post']);
Route::get('/edit-post/{post_id}', [PostController::class, 'edit_post']);
Route::post('/save-post', [PostController::class, 'save_post']);
Route::post('/update-post/{post_id}', [PostController::class, 'update_post']);


//Product

Route::get('/add-product', [ProductController::class, 'add_product']);
Route::get('/edit-product/{product_id}', [ProductController::class, 'edit_product']);


Route::get('users', [UserController::class, 'index'])->middleware('auth.roles');
Route::get('add-users', [UserController::class, 'add_users'])->middleware('auth.roles');
Route::get('delete-user-roles/{admin_id}', [UserController::class, 'delete_user_roles'])->middleware('auth.roles');
Route::post('store-users', [UserController::class, 'store_users']);
Route::post('assign-roles', [UserController::class, 'assign_roles'])->middleware('auth.roles');

Route::get('impersonate/{admin_id}', [UserController::class, 'impersonate']);
Route::get('impersonate-destroy', [UserController::class, 'impersonate_destroy']);


Route::get('/delete-product/{product_id}', [ProductController::class, 'delete_product']);
Route::get('/all-product', [ProductController::class, 'all_product']);
Route::get('/unactive-product/{product_id}', [ProductController::class, 'unactive_product']);
Route::get('/active-product/{product_id}', [ProductController::class, 'active_product']);
Route::post('/save-product', [ProductController::class, 'save_product']);
Route::post('/update-product/{product_id}', [ProductController::class, 'update_product']);
Route::post('/delete-document', [ProductController::class, 'delete_document']);
Route::get('/gg-document', [ProductController::class, 'gg_document']);

//Coupon
Route::post('/check-coupon', [CartController::class, 'check_coupon']);

Route::get('/unset-coupon', [CouponController::class, 'unset_coupon']);
Route::get('/insert-coupon', [CouponController::class, 'insert_coupon']);
Route::get('/delete-coupon/{coupon_id}', [CouponController::class, 'delete_coupon']);
Route::get('/list-coupon', [CouponController::class, 'list_coupon']);

Route::post('/insert-coupon-code', [CouponController::class, 'insert_coupon_code']);

//Cart
Route::post('/update-cart-quantity', [CartController::class, 'update_cart_quantity']);
Route::post('/update-cart', [CartController::class, 'update_cart']);
Route::post('/save-cart', [CartController::class, 'save_cart']);
Route::post('/add-cart-ajax', [CartController::class, 'add_cart_ajax']);
Route::get('/show-cart', [CartController::class, 'show_cart']);
Route::get('/gio-hang', [CartController::class, 'gio_hang']);
Route::get('/delete-to-cart/{rowId}', [CartController::class, 'delete_to_cart']);
Route::get('/del-product/{session_id}', [CartController::class, 'delete_product']);
Route::post('/update-quick-cart', [CartController::class, 'update_quick_cart']);

Route::get('/del-all-product', [CartController::class, 'delete_all_product']);
Route::get('/show-cart', [CartController::class, 'show_cart_menu']);
Route::get('/hover-cart', [CartController::class, 'hover_cart']);

Route::get('/remove-item', [CartController::class, 'remove_item']);

Route::get('/cart-session', [CartController::class, 'cart_session']);

//Checkout
Route::get('/dang-nhap', [CheckoutController::class, 'login_checkout']);
Route::get('/del-fee',  [CheckoutController::class, 'del_fee']);

Route::get('/logout-checkout',  [CheckoutController::class, 'logout_checkout']);
Route::post('/add-customer',  [CheckoutController::class, 'add_customer']);
Route::post('/order-place',  [CheckoutController::class, 'order_place']);
Route::post('/login-customer',  [CheckoutController::class, 'login_customer']);
Route::get('/checkout',  [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/payment',  [CheckoutController::class, 'payment']);
Route::post('/save-checkout-customer',  [CheckoutController::class, 'save_checkout_customer']);
Route::post('/calculate-fee',  [CheckoutController::class, 'calculate_fee']);
Route::post('/select-delivery-home',  [CheckoutController::class, 'select_delivery_home']);
Route::post('/confirm-order',  [CheckoutController::class, 'confirm_order']);

//Order
Route::get('/view-history-order/{order_code}',  [OrderController::class, 'view_history_order']);
Route::get('/history', [OrderController::class, 'history']);
Route::get('/delete-order/{order_code}', [OrderController::class, 'order_code']);
Route::get('/print-order/{checkout_code}', [OrderController::class, 'print_order']);
Route::get('/manage-order', [OrderController::class, 'manage_order']);
Route::get('/view-order/{order_code}', [OrderController::class, 'view_order']);
Route::post('/update-order-qty', [OrderController::class, 'update_order_qty']);
Route::post('/update-qty', [OrderController::class, 'update_qty']);
Route::post('/huy-don-hang', [OrderController::class, 'huy_don_hang']);


//Delivery
Route::get('/delivery', [DeliveryController::class, 'delivery']);
Route::post('/select-delivery', [DeliveryController::class, 'select_delivery']);
Route::post('/insert-delivery', [DeliveryController::class, 'insert_delivery']);
Route::post('/select-feeship', [DeliveryController::class, 'select_feeship']);
Route::post('/update-delivery', [DeliveryController::class, 'update_delivery']);

//Banner
Route::get('/manage-slider', [SliderController::class, 'manage_slider']);
Route::get('/add-slider', [SliderController::class, 'add_slider']);
Route::get('/delete-slide/{slide_id}', [SliderController::class, 'delete_slide']);
Route::post('/insert-slider', [SliderController::class, 'insert_slider']);
Route::get('/unactive-slide/{slide_id}', [SliderController::class, 'unactive_slide']);
Route::get('/active-slide/{slide_id}', [SliderController::class, 'active_slide']);

//Authentication roles
Route::get('/register-auth', [AuthController::class, 'register_auth']);
Route::get('/login-auth', [AuthController::class, 'login_auth']);
Route::get('/logout-auth', [AuthController::class, 'logout_auth']);

Route::post('/auth-register', [AuthController::class, 'register_auth_dashboard']);
Route::post('/auth-login', [AuthController::class, 'login']);

//Gallery
Route::get('add-gallery/{product_id}', [GalleryController::class, 'add_gallery']);
Route::post('select-gallery', [GalleryController::class, 'select_gallery']);
Route::post('insert-gallery/{pro_id}', [GalleryController::class, 'insert_gallery']);
Route::post('update-gallery-name', [GalleryController::class, 'update_gallery_name']);
Route::post('delete-gallery', [GalleryController::class, 'delete_gallery']);
Route::post('update-gallery', [GalleryController::class, 'update_gallery']);


//Video
Route::get('video', [VideoController::class, 'video']);
Route::get('video-shop', [VideoController::class, 'video_shop']);
Route::post('select-video', [VideoController::class, 'select_video']);
Route::post('insert-video', [VideoController::class, 'insert_video']);
Route::post('update-video', [VideoController::class, 'update_video']);
Route::post('delete-video', [VideoController::class, 'delete_video']);
Route::post('update-video-image', [VideoController::class, 'update_video_image']);
Route::post('watch-video', [VideoController::class, 'watch_video']);


//Document
Route::get('upload_file', [DocumentController::class, 'upload_file']);
Route::get('upload_image', [DocumentController::class, 'upload_image']);
Route::get('upload_video', [DocumentController::class, 'upload_video']);
Route::get('download_document/{path}/{name}', [DocumentController::class, 'download_document']);
Route::get('create_document', [DocumentController::class, 'create_document']);
Route::get('create_sub_dir', [DocumentController::class, 'create_sub_dir']);

Route::get('delete_document/{path}', [DocumentController::class, 'delete_document']);

//Folder
Route::get('create_folder', [DocumentController::class, 'create_folder']);
Route::get('rename_folder', [DocumentController::class, 'rename_folder']);
Route::get('delete_folder', [DocumentController::class, 'delete_folder']);

Route::get('list_document', [DocumentController::class, 'list_document']);
Route::get('read_data', [DocumentController::class, 'read_data']);

//Send Mail 
Route::get(
    '/send-coupon-vip/{coupon_time}/{coupon_condition}/{coupon_number}/{coupon_code}',
    [MailController::class, 'send_coupon_vip']
);
Route::get(
    '/send-coupon/{coupon_time}/{coupon_condition}/{coupon_number}/{coupon_code}',
    [MailController::class, 'send_coupon']
);

Route::get('/mail-example', [MailController::class, 'mail_example']);

Route::get('/send-mail', [MailController::class, 'send_mail']);
Route::get('/quen-mat-khau', [MailController::class, 'quen_mat_khau']);
Route::get('/update-new-pass', [MailController::class, 'update_new_pass']);
Route::post('/recover-pass', [MailController::class, 'recover_pass']);
Route::post('/reset-new-pass', [MailController::class, 'reset_new_pass']);


// Route::group(['prefix' => 'laravel-filemanager', 'middleware'], function () {
//     \UniSharp\LaravelFilemanager\Lfm::routes();
// });

Route::get('/create-spatie/{admin_id}', [UserRolesController::class, 'create']);
Route::get('/create-permission/{admin_id}', [UserRolesController::class, 'create_permission']);
Route::get('/index-spatie', [UserRolesController::class, 'index']);
Route::post('/assign-role/{admin_id}', [UserRolesController::class, 'assign_role']);
Route::post('/assign-permission/{admin_id}', [UserRolesController::class, 'assign_permission']);


Route::get('process-transaction', [PayPalController::class, 'processTransaction'])->name('processTransaction');
Route::get('success-transaction', [PayPalController::class, 'successTransaction'])->name('successTransaction');
Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');

//Cổng thanh toán
Route::post('/vnpay_payment', [CheckoutController::class, 'vnpay_payment']);
Route::post('/momo_payment', [CheckoutController::class, 'momo_payment']);
Route::post('/onepay_payment', [CheckoutController::class, 'onepay_payment']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
