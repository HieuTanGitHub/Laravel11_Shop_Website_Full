<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Cart;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();

use App\Models\City;
use App\Models\Province;
use App\Models\Customer;
use App\Models\Wards;
use App\Models\Feeship;
use App\Models\Slider;
use App\Models\Shipping;
use App\Models\CatePost;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderDetails;
use Mail;

class CheckoutController extends Controller
{
  public function execPostRequest($url, $data)
  {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
      )
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
  }
  public function momo_payment(Request $request)
  {

    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

    $partnerCode = 'MOMOBKUN20180529';
    $accessKey = 'klm05TvNBzhg7h7j';
    $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';


    $orderInfo = "Thanh toán qua MoMo";
    $amount = $_POST['total_momo'];
    $orderId = time() . "";
    $redirectUrl = "http://127.0.0.1:8000/checkout";
    $ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
    $extraData = "";

    $requestId = time() . "";
    $requestType = "payWithATM"; //captureWithWallet
    // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
    //before sign HMAC SHA256 signature
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);

    $data = array(
      'partnerCode' => $partnerCode,
      'partnerName' => "Test",
      "storeId" => "MomoTestStore",
      'requestId' => $requestId,
      'amount' => $amount,
      'orderId' => $orderId,
      'orderInfo' => $orderInfo,
      'redirectUrl' => $redirectUrl,
      'ipnUrl' => $ipnUrl,
      'lang' => 'vi',
      'extraData' => $extraData,
      'requestType' => $requestType,
      'signature' => $signature
    );
    $result = $this->execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);  // decode json

    //Just a example, please check more in there
    return redirect()->to($jsonResult['payUrl']);
    // dd($jsonResult);

    //header('Location: ' . $jsonResult['payUrl']); php thuần
  }
  public function vnpay_payment(Request $request)
  {
    $data = $request->all();
    $code_cart = rand(00, 9999); //mã đơn hàng : 1234
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "http://127.0.0.1:8000/checkout";
    $vnp_TmnCode = "1VYBIYQP"; //Mã website tại VNPAY 
    $vnp_HashSecret = "NOH6MBGNLQL9O9OMMFMZ2AX8NIEP50W1"; //Chuỗi bí mật

    $vnp_TxnRef = rand(1, 10000); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
    $vnp_OrderInfo = 'Thanh toán đơn hàng test';
    $vnp_OrderType = 'billpayment';
    $vnp_Amount = $data['total_vnpay'] * 100;
    $vnp_Locale = 'vn';
    // $vnp_BankCode = 'NCB';
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //127.0.0.1 or localhost

    //$startTime = date("YmdHis");
    //$expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

    $inputData = array(
      "vnp_Version" => "2.1.0",
      "vnp_TmnCode" => $vnp_TmnCode,
      "vnp_Amount" => $vnp_Amount,
      "vnp_Command" => "pay",
      "vnp_CreateDate" => date('YmdHis'),
      "vnp_CurrCode" => "VND",
      "vnp_IpAddr" => $vnp_IpAddr,
      "vnp_Locale" => $vnp_Locale,
      "vnp_OrderInfo" => $vnp_OrderInfo,
      "vnp_OrderType" => $vnp_OrderType,
      "vnp_ReturnUrl" => $vnp_Returnurl,
      "vnp_TxnRef" => $vnp_TxnRef,
      //"vnp_ExpireDate" => $expire
    );

    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
      $inputData['vnp_BankCode'] = $vnp_BankCode;
    }
    // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
    //   $inputData['vnp_Bill_State'] = $vnp_Bill_State;
    // }

    //var_dump($inputData);
    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
      if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
      } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
      }
      $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
      $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
      $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }
    $returnData = array(
      'code' => '00',
      'message' => 'success',
      'data' => $vnp_Url
    );
    if (isset($_POST['redirect'])) {
      // header('Location: ' . $vnp_Url); 
      return redirect()->to($vnp_Url);
      die();
    } else {
      echo json_encode($returnData);
    }
  }
  public function onepay_payment(Request $request)
  {
    /* -----------------------------------------------------------------------------

      Version 2.0

      @author OnePAY

      ------------------------------------------------------------------------------*/

    // *********************
    // START OF MAIN PROGRAM
    // *********************

    // Define Constants
    // ----------------
    // This is secret for encoding the MD5 hash
    // This secret will vary from merchant to merchant
    // To not create a secure hash, let SECURE_SECRET be an empty string - ""
    // $SECURE_SECRET = "secure-hash-secret";
    // Khóa bí mật - được cấp bởi OnePAY
    $SECURE_SECRET = "A3EFDFABA8653DF2342E8DAC29B51AF0";

    // add the start of the vpcURL querystring parameters
    // *****************************Lấy giá trị url cổng thanh toán*****************************
    $vpcURL = 'https://mtf.onepay.vn/onecomm-pay/vpc.op' . "?";

    // Remove the Virtual Payment Client URL from the parameter hash as we 
    // do not want to send these fields to the Virtual Payment Client.
    // bỏ giá trị url và nút submit ra khỏi mảng dữ liệu
    // unset($_POST["virtualPaymentClientURL"]); 
    // unset($_POST["SubButL"]);
    $vpc_Merchant = "ONEPAY";
    $vpc_AccessCode = "D67342C2";
    $vpc_MerchTxnRef = time();
    $vpc_OrderInfo = "JSECURETEST01";
    $vpc_Amount = $_POST['total_onepay'] * 100;
    $vpc_ReturnURL = "http://localhost:8080/weblinhkienmaytinh/checkout";
    $vpc_Version = "2";
    $vpc_Command = "pay";
    $vpc_Locale = "vn";
    $vpc_Currency = "VND";
    $data = array(
      'vpc_Merchant' => $vpc_Merchant,
      'vpc_AccessCode' => $vpc_AccessCode,
      'vpc_MerchTxnRef' => $vpc_MerchTxnRef,
      'vpc_OrderInfo' => $vpc_OrderInfo,
      'vpc_Amount' => $vpc_Amount,
      'vpc_ReturnURL' => $vpc_ReturnURL,
      'vpc_Version' => $vpc_Version,
      'vpc_Command' => $vpc_Command,
      'vpc_Locale' => $vpc_Locale,
      'vpc_Currency' => $vpc_Currency
    );
    //$stringHashData = $SECURE_SECRET; *****************************Khởi tạo chuỗi dữ liệu mã hóa trống*****************************
    $stringHashData = "";
    // sắp xếp dữ liệu theo thứ tự a-z trước khi nối lại
    // arrange array data a-z before make a hash
    ksort($data);

    // set a parameter to show the first pair in the URL
    // đặt tham số đếm = 0
    $appendAmp = 0;

    foreach ($data as $key => $value) {

      // create the md5 input and URL leaving out any fields that have no value
      // tạo chuỗi đầu dữ liệu những tham số có dữ liệu
      if (strlen($value) > 0) {
        // this ensures the first paramter of the URL is preceded by the '?' char
        if ($appendAmp == 0) {
          $vpcURL .= urlencode($key) . '=' . urlencode($value);
          $appendAmp = 1;
        } else {
          $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
        }
        //$stringHashData .= $value; *****************************sử dụng cả tên và giá trị tham số để mã hóa*****************************
        if ((strlen($value) > 0) && ((substr($key, 0, 4) == "vpc_") || (substr($key, 0, 5) == "user_"))) {
          $stringHashData .= $key . "=" . $value . "&";
        }
      }
    }
    //*****************************xóa ký tự & ở thừa ở cuối chuỗi dữ liệu mã hóa*****************************
    $stringHashData = rtrim($stringHashData, "&");
    // Create the secure hash and append it to the Virtual Payment Client Data if
    // the merchant secret has been provided.
    // thêm giá trị chuỗi mã hóa dữ liệu được tạo ra ở trên vào cuối url
    if (strlen($SECURE_SECRET) > 0) {
      //$vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($stringHashData));
      // *****************************Thay hàm mã hóa dữ liệu*****************************
      $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*', $SECURE_SECRET)));
    }

    // FINISH TRANSACTION - Redirect the customers using the Digital Order
    // ===================================================================
    // chuyển trình duyệt sang cổng thanh toán theo URL được tạo ra
    // header("Location: ".$vpcURL);
    return redirect()->to($vpcURL);
    // *******************
    // END OF MAIN PROGRAM
    // *******************


  }
  public function confirm_order(Request $request)
  {
    $data = $request->all();
    //get coupon
    if ($data['order_coupon'] != 'no') {
      $coupon = Coupon::where('coupon_code', $data['order_coupon'])->first();
      $coupon->coupon_used = $coupon->coupon_used . ',' . Session::get('customer_id');
      $coupon->coupon_time = $coupon->coupon_time - 1;
      $coupon_mail = $coupon->coupon_code;
      $coupon->save();
    } else {
      $coupon_mail = 'không có sử dụng';
    }
    //get van chuyen
    $shipping = new Shipping();
    $shipping->shipping_name = $data['shipping_name'];
    $shipping->shipping_email = $data['shipping_email'];
    $shipping->shipping_phone = $data['shipping_phone'];
    $shipping->shipping_address = $data['shipping_address'];
    $shipping->shipping_notes = $data['shipping_notes'];
    $shipping->shipping_method = $data['shipping_method'];
    $shipping->save();
    $shipping_id = $shipping->shipping_id;

    $checkout_code = substr(md5(microtime()), rand(0, 26), 5);

    //get order
    $order = new Order;
    $order->customer_id = Session::get('customer_id');
    $order->shipping_id = $shipping_id;
    $order->order_status = 1;
    $order->order_code = $checkout_code;

    date_default_timezone_set('Asia/Ho_Chi_Minh');

    $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');

    $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');;
    $order->created_at = $today;
    $order->order_date = $order_date;
    $order->save();


    if (Session::get('cart') == true) {
      foreach (Session::get('cart') as $key => $cart) {
        $order_details = new OrderDetails;
        $order_details->order_code = $checkout_code;
        $order_details->product_id = $cart['product_id'];
        $order_details->product_attribute = $cart['product_attribute'];
        $order_details->product_name = $cart['product_name'];
        $order_details->product_price = $cart['product_price'];
        $order_details->product_sales_quantity = $cart['product_qty'];
        $order_details->product_coupon =  $data['order_coupon'];
        $order_details->product_feeship = $data['order_fee'];
        $order_details->save();
      }
    }



    //send mail confirm
    $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');

    $title_mail = "Đơn hàng xác nhận ngày" . ' ' . $now;

    $customer = Customer::find(Session::get('customer_id'));

    $data['email'][] = $customer->customer_email;
    //lay gio hang
    if (Session::get('cart') == true) {

      foreach (Session::get('cart') as $key => $cart_mail) {

        $cart_array[] = array(
          'product_name' => $cart_mail['product_name'],
          'product_price' => $cart_mail['product_price'],
          'product_qty' => $cart_mail['product_qty']
        );
      }
    }
    //lay shipping
    if (Session::get('fee') == true) {
      $fee = Session::get('fee') . 'k';
    } else {
      $fee = '25k';
    }

    $shipping_array = array(
      'fee' =>  $fee,
      'customer_name' => $customer->customer_name,
      'shipping_name' => $data['shipping_name'],
      'shipping_email' => $data['shipping_email'],
      'shipping_phone' => $data['shipping_phone'],
      'shipping_address' => $data['shipping_address'],
      'shipping_notes' => $data['shipping_notes'],
      'shipping_method' => $data['shipping_method']

    );
    //lay ma giam gia, lay coupon code
    $ordercode_mail = array(
      'coupon_code' => $coupon_mail,
      'order_code' => $checkout_code,
    );

    // Mail::send('pages.mail.mail_order',  ['cart_array'=>$cart_array, 'shipping_array'=>$shipping_array ,'code'=>$ordercode_mail] , function($message) use ($title_mail,$data){
    //     $message->to($data['email'])->subject($title_mail);//send this mail with subject
    //     $message->from($data['email'],$title_mail);//send from this mail
    // });

    Session::forget('coupon');
    Session::forget('fee');
    Session::forget('cart');
  }
  public function del_fee()
  {
    Session::forget('fee');
    return redirect()->back();
  }

  public function AuthLogin()
  {
    $admin_id = Session::get('admin_id');
    if ($admin_id) {
      return Redirect::to('dashboard');
    } else {
      return Redirect::to('admin')->send();
    }
  }
  public function dang_xuat_khachhang()
  {
    Session::forget('customer_id');
    return redirect()->back();
  }

  public function calculate_fee(Request $request)
  {
    $data = $request->all();
    if ($data['matp']) {
      $feeship = Feeship::where('fee_matp', $data['matp'])->where('fee_maqh', $data['maqh'])->where('fee_xaid', $data['xaid'])->get();
      if ($feeship) {
        $count_feeship = $feeship->count();
        if ($count_feeship > 0) {
          foreach ($feeship as $key => $fee) {
            Session::put('fee', $fee->fee_feeship);
            Session::save();
          }
        } else {
          Session::put('fee', 25000);
          Session::save();
        }
      }
    }
  }
  public function select_delivery_home(Request $request)
  {
    $data = $request->all();
    if ($data['action']) {
      $output = '';
      if ($data['action'] == "city") {
        $select_province = Province::where('matp', $data['ma_id'])->orderby('maqh', 'ASC')->get();
        $output .= '<option>---Chọn quận huyện---</option>';
        foreach ($select_province as $key => $province) {
          $output .= '<option value="' . $province->maqh . '">' . $province->name_quanhuyen . '</option>';
        }
      } else {

        $select_wards = Wards::where('maqh', $data['ma_id'])->orderby('xaid', 'ASC')->get();
        $output .= '<option>---Chọn xã phường---</option>';
        foreach ($select_wards as $key => $ward) {
          $output .= '<option value="' . $ward->xaid . '">' . $ward->name_xaphuong . '</option>';
        }
      }
      echo $output;
    }
  }
  public function view_order($orderId)
  {
    $this->AuthLogin();
    $order_by_id = DB::table('tbl_order')
      ->join('tbl_customers', 'tbl_order.customer_id', '=', 'tbl_customers.customer_id')
      ->join('tbl_shipping', 'tbl_order.shipping_id', '=', 'tbl_shipping.shipping_id')
      ->join('tbl_order_details', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
      ->select('tbl_order.*', 'tbl_customers.*', 'tbl_shipping.*', 'tbl_order_details.*')->first();

    $manager_order_by_id  = view('admin.view_order')->with('order_by_id', $order_by_id);
    return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
  }
  public function login_checkout(Request $request)
  {
    //category post
    $category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();
    //slide
    $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();

    //seo 
    $meta_desc = "Đăng nhập thanh toán";
    $meta_keywords = "Đăng nhập thanh toán";
    $meta_title = "Đăng nhập thanh toán";
    $url_canonical = $request->url();
    //--seo 

    $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
    $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

    return view('pages.checkout.login_checkout')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('slider', $slider)->with('category_post', $category_post);
  }
  public function add_customer(Request $request)
  {

    $data = array();
    $data['customer_name'] = $request->customer_name;
    $data['customer_phone'] = $request->customer_phone;
    $data['customer_email'] = $request->customer_email;
    $data['customer_password'] = md5($request->customer_password);

    $customer_id = DB::table('tbl_customers')->insertGetId($data);

    Session::put('customer_id', $customer_id);
    Session::put('customer_name', $request->customer_name);
    return Redirect::to('/checkout');
  }
  public function checkout(Request $request)
  {
    //category post
    $category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();
    //seo 
    //slide
    $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();

    $meta_desc = "Đăng nhập thanh toán";
    $meta_keywords = "Đăng nhập thanh toán";
    $meta_title = "Đăng nhập thanh toán";
    $url_canonical = $request->url();
    //--seo 

    $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
    $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();
    $city = City::orderby('matp', 'ASC')->get();

    return view('pages.checkout.show_checkout')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('city', $city)->with('slider', $slider)->with('category_post', $category_post);
  }
  public function save_checkout_customer(Request $request)
  {
    $data = array();
    $data['shipping_name'] = $request->shipping_name;
    $data['shipping_phone'] = $request->shipping_phone;
    $data['shipping_email'] = $request->shipping_email;
    $data['shipping_notes'] = $request->shipping_notes;
    $data['shipping_address'] = $request->shipping_address;

    $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

    Session::put('shipping_id', $shipping_id);

    return Redirect::to('/payment');
  }
  public function payment(Request $request)
  {
    //seo 
    $meta_desc = "Đăng nhập thanh toán";
    $meta_keywords = "Đăng nhập thanh toán";
    $meta_title = "Đăng nhập thanh toán";
    $url_canonical = $request->url();
    //--seo 
    $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
    $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();
    return view('pages.checkout.payment')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical);
  }
  public function order_place(Request $request)
  {
    //insert payment_method
    //seo 
    $meta_desc = "Đăng nhập thanh toán";
    $meta_keywords = "Đăng nhập thanh toán";
    $meta_title = "Đăng nhập thanh toán";
    $url_canonical = $request->url();
    //--seo 
    $data = array();
    $data['payment_method'] = $request->payment_option;
    $data['payment_status'] = 'Đang chờ xử lý';
    $payment_id = DB::table('tbl_payment')->insertGetId($data);

    //insert order
    $order_data = array();
    $order_data['customer_id'] = Session::get('customer_id');
    $order_data['shipping_id'] = Session::get('shipping_id');
    $order_data['payment_id'] = $payment_id;
    $order_data['order_total'] = Cart::total();
    $order_data['order_status'] = 'Đang chờ xử lý';
    $order_id = DB::table('tbl_order')->insertGetId($order_data);

    //insert order_details
    $content = Cart::content();
    foreach ($content as $v_content) {
      $order_d_data['order_id'] = $order_id;
      $order_d_data['product_id'] = $v_content->id;
      $order_d_data['product_name'] = $v_content->name;
      $order_d_data['product_price'] = $v_content->price;
      $order_d_data['product_sales_quantity'] = $v_content->qty;
      DB::table('tbl_order_details')->insert($order_d_data);
    }
    if ($data['payment_method'] == 1) {

      echo 'Thanh toán thẻ ATM';
    } elseif ($data['payment_method'] == 2) {
      Cart::destroy();

      $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
      $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();
      return view('pages.checkout.handcash')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical);
    } else {
      echo 'Thẻ ghi nợ';
    }

    //return Redirect::to('/payment');
  }
  public function logout_checkout()
  {
    Session::forget('customer_id');
    Session::forget('coupon');

    return Redirect::to('/dang-nhap');
  }
  public function login_customer(Request $request)
  {

    $email = $request->email_account;
    $password = md5($request->password_account);
    $result = DB::table('tbl_customers')->where('customer_email', $email)->where('customer_password', $password)->first();
    if (Session::get('coupon') == true) {
      Session::forget('coupon');
    }

    if ($result) {
      Session::put('customer_id', $result->customer_id);
      return Redirect::to('/checkout');
    } else {
      return Redirect::to('/dang-nhap');
    }
    Session::save();
  }
  public function manage_order()
  {

    $this->AuthLogin();
    $all_order = DB::table('tbl_order')
      ->join('tbl_customers', 'tbl_order.customer_id', '=', 'tbl_customers.customer_id')
      ->select('tbl_order.*', 'tbl_customers.customer_name')
      ->orderby('tbl_order.order_id', 'desc')->get();
    $manager_order  = view('admin.manage_order')->with('all_order', $all_order);
    return view('admin_layout')->with('admin.manage_order', $manager_order);
  }
}
