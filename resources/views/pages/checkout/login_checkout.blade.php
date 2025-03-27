@extends('layout')
@section('content')
    <section id="form"><!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form"><!--login form-->
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {!! session()->get('message') !!}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-danger">
                                {!! session()->get('error') !!}
                            </div>
                        @endif
                        <h2>Đăng nhập tài khoản</h2>
                        <form action="{{ URL::to('/login-customer') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="text" name="email_account" placeholder="Tài khoản" />
                            <input type="password" name="password_account" placeholder="Password" />
                            <span>
                                <input type="checkbox" class="checkbox">
                                Ghi nhớ đăng nhập
                            </span>
                            <span>
                                <a href="{{ url('/quen-mat-khau') }}">Quên mật khẩu</a>
                            </span>
                            <button type="submit" class="btn btn-default">Đăng nhập</button>

                        </form>

                        <style type="text/css">
                            ul.list-login {
                                margin: 10px;
                                padding: 0;
                            }

                            ul.list-login li {
                                display: inline;
                                margin: 5px;
                            }
                        </style>

                        <ul class="list-login">

                            <li>
                                <a href="{{ url('login-customer-google') }}">
                                    <img width="10%" alt="Đăng nhập bằng tài khoản google"
                                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQRB4kg1jgnqD5fEaCSHKMoUdFeTBj9CH_opA&s">
                                    <h5>Login by Google</h5>
                                </a>
                            </li>


                        </ul>


                    </div><!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">Hoặc</h2>
                </div>
                <div class="col-md-6">
                    <div class="signup-form"><!--sign up form-->
                        <h2>Đăng ký</h2>
                        <form action="{{ URL::to('/add-customer') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="text" name="customer_name" placeholder="Họ và tên" />
                            <input type="email" name="customer_email" placeholder="Địa chỉ email" />
                            <input type="password" name="customer_password" placeholder="Mật khẩu" />
                            <input type="text" name="customer_phone" placeholder="Phone" />
                            <button type="submit" class="btn btn-default">Đăng ký</button>
                        </form>
                    </div><!--/sign up form-->
                </div>
            </div>
        </div>
    </section><!--/form-->
@endsection
