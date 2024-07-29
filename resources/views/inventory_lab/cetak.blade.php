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

    header img {
        width: 100%;
    }

    th {
        text-align: left;
    }
</style>

<body>
    <header>
        <img src="src/images/kop.png" alt="kop">
    </header>

    <div class="namalab">
        <table>
            <tr>
                <th>Nama Laboratorium</th>
                <th>:</th>
                <th>LAB {{ Str::upper($data->nama) }}</th>
            </tr>
            <tr>
                <th>Prodi</th>
                <th>:</th>
                <th>INFORMATIKA</th>
            </tr>
            <tr>
                <th>Fakultas</th>
                <th>:</th>
                <th>SANINS DAN TEKNOLOGI</th>
            </tr>
        </table>
    </div>


    <div class="data">
        <p>Data Inventaris Laboratorium</p>
        <table border="1" width="100%" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <td rowspan="2">No</td>
                    <td rowspan="2">Nama Barang</td>
                    <td rowspan="2">Jumlah</td>
                    <td colspan="2" align="center">Kondisi saat ini</td>
                    <td rowspan="2">Keterangan</td>
                </tr>
                <tr>
                    <td>Kondisi Rusak</td>
                    <td>Kondisi Baik</td>
                </tr>
            </thead>

            <tbody>
                @foreach ($barang as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ Str::upper($item['nama']) }}</td>
                        <td align="center">{{ $item['jml_baik'] + $item['jml_rusak'] }}</td>
                        <td align="center">{{ $item['jml_baik'] }}</td>
                        <td align="center">{{ $item['jml_rusak'] }}</td>
                        <td>{{ Str::upper($item['keterangan']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
