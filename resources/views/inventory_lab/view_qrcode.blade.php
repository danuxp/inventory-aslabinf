<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/core.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/style.css') }}">
</head>

<body>
    <div class="row mt-5">
        <div class="col-md-6 mx-auto">
            <div class="card card-box">
                <h4 class="card-header font-weight-bold">LAB {{ $data->lab->nama }}</h4>
                <div class="card-body">


                    <div class="text-center mb-3">
                        <img src="{{ asset('vendors/images/aslab-logo.png') }}" alt="logo" width="120">
                        <h5 class="">{{ env('APP_NAME') }}</h5>
                    </div>


                    <h5 class="card-title">{{ Str::upper($barang['nama']) . '-' . $key }}</h5>
                    <table class="table">
                        <tr>
                            <td>Jumlah Baik</td>
                            <td>:</td>
                            <td>{{ $barang['jml_baik'] }}</td>
                        </tr>
                        <tr>
                            <td>Jumlah Rusak</td>
                            <td>:</td>
                            <td>{{ $barang['jml_rusak'] }}</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>:</td>
                            <td>{{ $barang['jml_baik'] + $barang['jml_rusak'] }}</td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>:</td>
                            <td>{{ $barang['keterangan'] }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer text-muted">{{ date('Y-m-d', strtotime($data->created_at)) }}</div>
            </div>
        </div>
    </div>
    <script src="{{ asset('vendors/scripts/script.min.js') }}"></script>

</body>

</html>
