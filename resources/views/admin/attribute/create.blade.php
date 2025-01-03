@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">

            <section class="panel">
                <header class="panel-heading">
                    Thêm thuộc tính
                </header>
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <form action="{{ route('attribute.store') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên thuộc tính</label>
                        <input type="text" required class="form-control" name="name" id="slug"
                            placeholder="danh mục">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputPassword1">Mô tả thuộc tính</label>
                        <textarea style="resize: none" rows="8" class="form-control" name="description" id="exampleInputPassword1"
                            required placeholder="Mô tả danh mục"></textarea>
                    </div>



                    <button type="submit" name="add_attribute" class="btn btn-info">Thêm thuộc
                        tính mới</button>
                </form>


            </section>
        </div>
    @endsection
