<?php

use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

function tanggal_indo($source_date)
{
    $d = strtotime($source_date);

    $year = date('Y', $d);
    $month = date('n', $d);
    $day = date('d', $d);
    $day_name = date('D', $d);

    $day_names = array(
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jum\'at',
        'Sat' => 'Sabtu'
    );
    $month_names = array(
        '1' => 'Januari',
        '2' => 'Februari',
        '3' => 'Maret',
        '4' => 'April',
        '5' => 'Mei',
        '6' => 'Juni',
        '7' => 'Juli',
        '8' => 'Agustus',
        '9' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    );
    $day_name = $day_names[$day_name];
    $month_name = $month_names[$month];

    $date = "$day_name, $day $month_name $year";

    return $date;
}

function jenis_rapat($jenis = '')
{
    switch ($jenis) {
        case 'RM':
            return 'Rapat Mingguan';
            break;
        case 'RB':
            return 'Rapat Bulanan';
            break;
        case 'RI':
            return 'Rapat Incidental (bersifat mendadak)';
            break;

        default:
            break;
    }
}

function qrcode($string, $size = 200)
{
    // $data = QrCode::size($size)
    //     ->format('png')
    //     ->merge('/storage/app/aslab-logo.png')
    //     ->errorCorrection('M')
    //     ->generate($string);

    // return response($data)
    //     ->header('Content-type', 'image/png');
    return QrCode::generate($string);
}
