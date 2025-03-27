@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê quyền users
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    {{--  <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select> --}}
                    <button class="btn btn-sm btn-default">Apply</button>
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search">
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>

            </div>
            <footer class="panel-footer">
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tên user</th>
                                <th>Email user</th>
                                <th>Vai trò</th>
                                <th>Quyền</th>
                                <th>Quản lý</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $key => $u)
                                <tr>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>

                                    <td>

                                        @foreach ($u->roles as $key => $role)
                                            {{ $role->name }}
                                        @endforeach


                                    </td>
                                    <td>
                                        @foreach ($role->permissions as $key => $per)
                                            <span class="badge badge-primary">{{ $per->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>

                                        <a href="{{ url('create-permission/' . $u->id) }}" class="btn btn-danger">Cấp
                                            quyền</a>

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        {{--  <ul class="pagination pagination-sm m-t-none m-b-none">
             {!!$category_post->links()!!}
          </ul> --}}
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
