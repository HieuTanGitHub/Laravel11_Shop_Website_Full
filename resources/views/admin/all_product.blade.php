@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê sản phẩm
            </div>

            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light" id="myTable">
                        <thead>
                            <tr>
                                <th style="width:20px;">
                                    <label class="i-checks m-b-none">
                                        <input type="checkbox"><i></i>
                                    </label>
                                </th>
                                <th>Tên sản phẩm</th>
                                <th>Thư viện ảnh</th>
                                <th>Thuộc tính</th>

                                <th>Tài liệu</th>
                                <th>Số lượng</th>
                                <th>Slug</th>
                                <th>Giá bán</th>
                                <th>Giá gốc</th>
                                <th>Hình sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Thương hiệu</th>

                                <th>Hiển thị</th>

                                <th style="width:30px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_product as $key => $pro)
                                <tr>
                                    <td><label class="i-checks m-b-none"><input type="checkbox"
                                                name="post[]"><i></i></label>
                                    </td>

                                    <td>{{ $pro->product_name }}</td>
                                    <td><a href="{{ url('/add-gallery/' . $pro->product_id) }}">Thêm thư viện ảnh</a></td>
                                    <td><a href="{{ url('product-attribute', [$pro->product_id]) }}">Thêm thuộc tính</a>
                                    </td>
                                    @if ($pro->product_file)
                                        @php
                                            $filename = $pro->product_file;
                                            $name = pathinfo($filename, PATHINFO_FILENAME);
                                            $extension = pathinfo($filename, PATHINFO_EXTENSION);
                                        @endphp
                                        @if ($extension == 'pdf')
                                            <td><a target="_blank"
                                                    href="{{ asset('uploads/document/' . $pro->product_file) }}">Xem
                                                    file</a>
                                            </td>
                                        @elseif($extension == 'docx')
                                            <td><a target="_blank"
                                                    href="https://view.officeapps.live.com/op/view.aspx?src={{ url('uploads/document/' . $pro->product_file) }}">Xem
                                                    file</a></td>
                                        @endif
                                    @else
                                        <td>Không file</td>
                                    @endif

                                    <td>{{ $pro->product_quantity }}</td>
                                    <td>{{ $pro->product_slug }}</td>
                                    <td>{{ number_format($pro->product_price, 0, ',', '.') }}đ</td>
                                    <td>{{ number_format($pro->price_cost, 0, ',', '.') }}đ</td>
                                    <td><img src="uploads/product/{{ $pro->product_image }}" height="100" width="100">
                                    </td>
                                    <td>{{ $pro->category_name }}</td>
                                    <td>{{ $pro->brand_name }}</td>

                                    <td><span class="text-ellipsis">
                                            <?php
               if($pro->product_status==0){
                ?>
                                            <a href="{{ URL::to('/unactive-product/' . $pro->product_id) }}"><span
                                                    class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                                            <?php
                 }else{
                ?>
                                            <a href="{{ URL::to('/active-product/' . $pro->product_id) }}"><span
                                                    class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                                            <?php
               }
              ?>
                                        </span></td>

                                    <td>
                                        <a href="{{ URL::to('/edit-product/' . $pro->product_id) }}"
                                            class="active styling-edit" ui-toggle-class="">
                                            <i class="fa fa-pencil-square-o text-success text-active"></i></a>
                                        <a onclick="return confirm('Bạn có chắc là muốn xóa sản phẩm này ko?')"
                                            href="{{ URL::to('/delete-product/' . $pro->product_id) }}"
                                            class="active styling-edit" ui-toggle-class="">
                                            <i class="fa fa-times text-danger text"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
