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
                <li><a href="/">Login</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="register-page-wrap d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="vendors/images/register-page-img.png" alt="">
            </div>
            <div class="col-md-6">
                <div class="bg-white box-shadow border-radius-10 p-5">
                    <div class="login-title">
                        <h2 class="text-center text-primary pb-3">Registrasi</h2>
                    </div>
                    <form action="/register-valid" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="form-control-label">Nim</label>
                            <input type="text" class="form-control @error('nim') form-control-danger @enderror"
                                name="nim" placeholder="Masukkan Nim" value="{{ old('nim') }}" required>
                            @error('nim')
                            <div class="form-control-feedback has-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama_lengkap') form-control-danger @enderror"
                                name="nama_lengkap" placeholder="Masukkan Nama Lengkap"
                                value="{{ old('nama_lengkap') }}" required>
                            @error('nama_lengkap')
                            <div class="form-control-feedback has-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Nama Cantik</label>
                            <input type="text" class="form-control @error('nama_cantik') form-control-danger @enderror"
                                name="nama_cantik" placeholder="Masukkan Nama Cantik" value="{{ old('nama_cantik') }}"
                                required>
                            @error('nama_cantik')
                            <div class="form-control-feedback has-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">Angkatan</label>
                                <select class="form-control selectpicker" title="Pilih Angkatan" name="angkatan"
                                    required>
                                    @foreach ($angkatan as $row)
                                    <option>{{ $row->angkatan_ke }}</option>
                                    @endforeach
                                </select>
                                @error('angkatan')
                                <div class="form-control-feedback has-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-control-label">Jenis Kelamin</label>
                                <div class="jk">
                                    <div class="custom-control custom-radio custom-control-inline pb-0">
                                        <input type="radio" id="male" name="kelamin" value="L"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="male">Laki</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline pb-0">
                                        <input type="radio" id="female" name="kelamin" value="P"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="female">Perempuan</label>
                                    </div>
                                </div>
                                @error('kelamin')
                                <div class="form-control-feedback has-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Email</label>
                            <input type="email" class="form-control @error('email') form-control-danger @enderror"
                                name="email" placeholder="Masukkan Email" value="{{ old('email') }}" required>
                            @error('email')
                            <div class="form-control-feedback has-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Username</label>
                            <input type="text" class="form-control @error('username') form-control-danger @enderror"
                                name="username" placeholder="Masukkan Username" value="{{ old('username') }}" required>
                            @error('username')
                            <div class="form-control-feedback has-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Password</label>
                            <input type="password" class="form-control @error('password') form-control-danger @enderror"
                                name="password" placeholder="**********" required>
                            @error('password')
                            <div class="form-control-feedback has-danger">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Konfirmasi Password</label>
                            <input type="password"
                                class="form-control @error('password2') form-control-danger @enderror" name="password2"
                                placeholder="**********" required>
                            @error('password2')
                            <div class="form-control-feedback has-danger">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">Register</button>
                                </div>
                                <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR</div>
                                <div class="input-group mb-0">
                                    <a class="btn btn-outline-primary btn-lg btn-block" href="/">Click To Login</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if (session()->get('notif-error'))
<script>
    swal(
                {
                    title: 'Good job!',
                    text: 'You clicked the button!',
                    type: 'errpr',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger'
                }
            );
</script>
@endif

@endsection