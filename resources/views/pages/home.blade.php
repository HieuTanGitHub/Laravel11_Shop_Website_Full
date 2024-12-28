@extends('layout')

@section('slider')
  @include('pages.include.slider')
@endsection

@section('sidebar')
  @include('pages.include.sidebar')
@endsection

@section('content')
<div class="features_items"><!--features_items-->

                    <div class="category-tab"><!--category-tab-->
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                @php 
                                    $i = 0;
                                @endphp
                               

                                @foreach($cate_pro_tabs as $key => $cat_tab)
                                    @php 
                                    $i++;
                                    @endphp
                                <li class="tabs_pro {{$i==1 ? 'active' : ''}}" data-id="{{$cat_tab->category_id}}"><a href="#tshirt" data-toggle="tab">{{$cat_tab->category_name}}</a></li>

                                @endforeach

                            </ul>
                        </div>

                        <div id="tabs_product"></div>

                    </div>


                        <h2 class="title text-center">Sản phẩm mới nhất</h2>

                        <div id="all_product"></div>    
                            
                        <div id="cart_session"></div>
                        

                    </div><!--features_items-->
                    <style type="text/css">
                      div#quick-cart {
                            margin-top: 60px;
                        }
                    </style>

                    <!-- Modal giỏ hàng -->
                      <div class="modal fade" id="quick-cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Giỏ hàng của bạn</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <div class="show_quick_cart_alert"></div>
                                <div id="show_quick_cart"></div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Modal so sanh -->
                       
                      <div class="modal fade" id="sosanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">So sánh sản phẩm</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <table class="table table-striped" id="row_compare">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">View</th>
                                        <th scope="col">Management</th>
                                      </tr>
                                    </thead>
                                    <tbody>

                                    
                                     
                                    </tbody>
                                  </table>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         
                            </div>
                          </div>
                        </div>
                      </div>
                     <!-- Modal xem nhanh-->
                            <div class="modal fade" style="margin-top:50px" id="xemnhanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-lg"  role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title product_quickview_title" id="">

                                                        <span id="product_quickview_title"></span>
                                                        
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body">
                                                    <style type="text/css">
                                                        span#product_quickview_content img {
                                                            width: 100%;
                                                        }

                                                        @media screen and (min-width: 768px) {
                                                            .modal-dialog {
                                                              width: 700px; /* New width for default modal */
                                                            }
                                                            .modal-sm {
                                                              width: 350px; /* New width for small modal */
                                                            }
                                                        }
                                                        
                                                        @media screen and (min-width: 992px) {
                                                            .modal-lg {
                                                              width: 1200px; /* New width for large modal */
                                                            }
                                                        }
                                                    </style>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <span id="product_quickview_image"></span>
                                                            <span id="product_quickview_gallery"></span>
                                                        </div>
                                                        <form>
                                                            @csrf
                                                            <div id="product_quickview_value"></div>
                                                        <div class="col-md-7">
                                                            <h2><span id="product_quickview_title"></span></h2>
                                                            <p>Mã ID: <span id="product_quickview_id"></span></p>
                                                            <p style="font-size: 20px; color: brown;font-weight: bold;">Giá sản phẩm : <span id="product_quickview_price"></span></p>
                                
                                                                <label>Số lượng:</label>

                                                                <input name="qty" type="number" min="1" class="cart_product_qty_"  value="1" />
                                                             
                                                            </span>
                                                            <h4 style="font-size: 20px; color: brown;font-weight: bold;">Mô tả sản phẩm</h4>
                                                            <hr>
                                                            <p><span id="product_quickview_desc"></span></p>
                                                            <p><span id="product_quickview_content"></span></p>
                                                            
                                                            <div id="product_quickview_button"></div>
                                                            <div id="beforesend_quickview"></div>
                                                        </div>
                                                        </form>

                                                    </div>
                                                   
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                    <button type="button" class="btn btn-default redirect-cart">Đi tới giỏ hàng</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div> 
                     {{--  <ul class="pagination pagination-sm m-t-none m-b-none">
                       {!!$all_product->links()!!}
                      </ul> --}}
        <!--/recommended_items-->

@endsection