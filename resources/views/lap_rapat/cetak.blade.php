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
</style>

<body>
    <header>
        <img src="src/images/kop.png" alt="kop">
    </header>
    <table>
        <tr>
            <td> Nama Rapat</td>
            <td>:</td>
            <td> {{ jenis_rapat($data->jenis) }} </td>
        </tr>
        <tr>
            <td> Hari / Tanggal</td>
            <td>:</td>
            <td> {{ tanggal_indo($data->tanggal) }} </td>
        </tr>
        <tr>
            <td> Waktu </td>
            <td>:</td>
            <td> {{ date('H:i', strtotime($data->created_at)) . ' WIB - Selesai' }} </td>
        </tr>
        <tr>
            <td> Tempat </td>
            <td>:</td>
            <td> {{ $data->tempat }} </td>
        </tr>
        <tr>
            <td> Notulen </td>
            <td>:</td>
            <td> {{ $data->author }} </td>
        </tr>
    </table>

    <p>
        Adapun hasil {{ jenis_rapat($data->jenis) }} pada hari ini meliputi : 
    </p>

    <div class="hasil">
        {!! html_entity_decode($data->catatan) !!}
    </div>

</body>

</html>