@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">

            <section class="panel">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attributes as $attr)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attr->name }}</td>
                                <td>{{ $attr->description }}</td>
                                <td>
                                    <a href="{{ route('attribute.edit', $attr->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('attribute.destroy', $attr->id) }}"
                                        onclick="return confirm('Bạn có muộn xóa thuộc tính này ko?')" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </section>
        </div>
    @endsection
