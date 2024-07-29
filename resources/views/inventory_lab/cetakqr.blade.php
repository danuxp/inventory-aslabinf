<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>

<style>
    @page {
        margin-top: 0;
    }

    th {
        text-align: left;
    }

    .qrcode {
        display: flex;
    }
</style>

<body>
    @php
        $jml = $barang['jml_baik'] + $barang['jml_rusak'];
        $qr = $barang['nama'] . '_' . $id . '_' . $key;
    @endphp
    <div class="data">
        <p>Data QR Inventaris Laboratorium {{ Str::upper($data->nama) }}</p>
        <div class="qrcode">
            @for ($i = 0; $i < $jml; $i++)
            @endfor
        </div>



    </div>
</body>

</html>
