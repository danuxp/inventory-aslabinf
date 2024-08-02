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
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .qr {
        display: flex;
        flex-direction: column;
        border: 1px solid #0e0e0e;
        padding: 0.8rem;
    }

    .label {
        display: flex;
        flex-direction: column;
        margin-top: 0.3rem;
        line-height: 1rem;
        text-align: center;
    }

    .title p {
        display: inline;
    }

    small {
        font-size: .7rem;
    }

    @media print {
        .no-print {
            display: none;
        }
    }
</style>

<body>
    @php
        $jml = $barang['jml_baik'] + $barang['jml_rusak'];
        $qr = $barang['nama'] . '_' . $id . '_' . $key . '_';
    @endphp
    <div class="data">
        <div class="title">
            <p>Data QR Inventaris Laboratorium {{ Str::upper($data->lab->nama) }}</p>
            <button type="button" onclick="window.print()" class="no-print">Print</button>
        </div>

        <div class="qrcode">
            @for ($i = 1; $i <= $jml; $i++)
                <div class="qr">
                    @php
                        $qr_code = base64_encode($qr . $i);
                    @endphp
                    {{ qrcode($qr_code) }}
                    <div class="label">
                        <small>{{ Str::upper($barang['nama']) . '-' . $i }}</small>
                        <small>{{ $data->nama }}</small>
                    </div>
                </div>
            @endfor
        </div>



    </div>
</body>

</html>
