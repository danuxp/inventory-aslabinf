@extends('layout.main')

@section('content')
    <div class="card card-box">
        <h5 class="card-header">Lab {{ $data->nama }}</h5>
        <div class="card-body">
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
@endsection
