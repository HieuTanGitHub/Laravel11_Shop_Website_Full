@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm thuộc tính cho sản phẩm
                </header>
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>

                @if ($errors->has('name'))
                    <div class="alert alert-danger">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <div class="row" style="padding: 15px">
                    <div class="col-md-5">
                        <form action="{{ route('product-attribute.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sản phẩm</label>
                                <input type="hidden" value="{{ $product->product_id }}" name="product_id"><input
                                    type="text" class="form-control" name="product_name" readonly
                                    value="{{ $product->product_name }}" placeholder="danh mục">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên thuộc tính</label>
                                <input type="text" required class="form-control" name="name" id="slug"
                                    placeholder="danh mục">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá</label>
                                <input type="number" required min="1" class="form-control" name="price"
                                    id="slug" placeholder="danh mục">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số lượng</label>
                                <input type="number" required min="1" class="form-control" name="quantity"
                                    id="slug" placeholder="danh mục">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh thuộc tính</label>
                                <input type="file" required name="image" class="form-control" id="exampleInputEmail1">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả thuộc tính</label>
                                <textarea style="resize: none" rows="8" class="form-control" name="description" id="exampleInputPassword1"
                                    required placeholder="Mô tả danh mục"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Thuộc tính</label>
                                <select name="attribute_id" class="form-control input-sm m-bot15" required>

                                    @foreach ($attribute as $key => $val)
                                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach


                                </select>
                            </div>


                            <button type="submit" name="add_attribute" class="btn btn-info">Thêm thuộc
                                tính</button>
                        </form>
                    </div>
                    <div class="col-md-7 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Tên thuộc tính</th>
                                    <th scope="col">Thuộc tính</th>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Quản lý</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product_attribute as $key => $pro_attr)
                                    <tr>
                                        <th scope="row">{{ $key }}</th>
                                        <td>{{ $pro_attr->product->product_name }}</td>
                                        <td>{{ $pro_attr->name }}</td>
                                        <td>{{ $pro_attr->attribute->name }}</td>
                                        <td><img src="{{ asset('/uploads/attribute/' . $pro_attr->image) }}"
                                                width="100%"></td>
                                        <td>{{ $pro_attr->quantity }}</td>
                                        <td>{{ number_format($pro_attr->price, 0, ',', '.') }}đ</td>
                                        <td>
                                            <form action="{{ route('product-attribute.delete', $pro_attr->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this attribute?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>



            </section>

        </div>
    @endsection
