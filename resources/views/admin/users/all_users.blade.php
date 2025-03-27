@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê users
            </div>

            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox"><i></i>
                                </label>
                            </th>

                            <th>Tên user</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Password</th>


                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admin as $key => $user)
                            <form action="{{ url('/assign-roles') }}" method="POST">
                                @csrf
                                <tr>
                                    <td>
                                        <label class="i-checks m-b-none">
                                            <input type="checkbox" name="post[]" value="{{ $user->id }}"><i></i>
                                        </label>
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        @if ($user->roles->isNotEmpty())
                                            {{ $user->roles->pluck('name')->join(', ') }}
                                        @else
                                            No roles assigned
                                        @endif
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                        <input type="hidden" name="admin_email" value="{{ $user->email }}">
                                        <input type="hidden" name="admin_id" value="{{ $user->id }}">
                                    </td>
                                    <td>{{ $user->phone ?? 'N/A' }}</td>
                                    <td>******</td> <!-- Masked password -->
                                    <td>
                                        <!-- Role Assignment Checkboxes -->
                                        @foreach ($roles as $role)
                                            <div>
                                                <label>
                                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                                        {{ $user->roles->contains('name', $role->name) ? 'checked' : '' }}>
                                                    {{ ucfirst($role->name) }}
                                                </label>
                                            </div>
                                        @endforeach


                                        <p>
                                            @if ($user->roles->contains('name', 'admin'))
                                                <input type="submit" value="Phân quyền" class="btn btn-sm btn-default">
                                            @endif
                                        </p>


                                        <!-- Delete User Link -->
                                        <p>
                                            <a style="margin:5px 0;" class="btn btn-sm btn-danger"
                                                href="{{ url('/delete-user-roles/' . $user->id) }}">
                                                Xóa user
                                            </a>
                                        </p>
                                    </td>

                                </tr>
                            </form>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">

                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {!! $admin->links() !!}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
