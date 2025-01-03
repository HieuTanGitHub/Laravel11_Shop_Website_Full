@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">

            <section class="panel">
                <header class="panel-heading">
                    Cập nhật thuộc tính
                </header>
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <form action="{{ route('attribute.update', $attribute->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="{{ old('name', $attribute->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" required>{{ old('description', $attribute->description) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>


            </section>
        </div>
    @endsection
