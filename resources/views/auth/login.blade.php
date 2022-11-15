@extends('layout.auth')

@section('authContent')
<div class="login-header box-shadow">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="brand-logo">
            <a href="login.html">
                <img src="vendors/images/aslab-logo.png" alt="logo" width="50">
                <span class="text-dark">SINAKA</span>
            </a>
        </div>
        <div class="login-menu">
            <ul>
                <li><a href="/register">Register</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7">
                <img src="vendors/images/login-page-img.png" alt="">
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10">
                    <div class="login-title">
                        <h2 class="text-center text-primary">Login</h2>
                    </div>
                    <form action="/login-valid" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="form-control-label">Nim / Username</label>
                            <input type="text" class="form-control @error('username') form-control-danger @enderror"
                                name="username" placeholder="Nim atau Username">
                            @error('username')

                            <div class="form-control-feedback has-danger">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Password</label>
                            <input type="text" class="form-control @error('password') form-control-danger @enderror"
                                name="password" placeholder="**********">
                            @error('password')

                            <div class="form-control-feedback has-danger">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                                </div>
                                <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR</div>
                                <div class="input-group mb-0">
                                    <a class="btn btn-outline-primary btn-lg btn-block" href="/register">Register To
                                        Create Account</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if (session()->has('notif-success'))
<script>
    swal(
                {
                    title: 'Good job!',
                    text: 'Registration is successful, please login!',
                    type: 'success',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success'
                }
            );
</script>
@endif

@endsection