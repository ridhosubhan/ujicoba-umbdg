<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Nama Lengkap
if (!function_exists('nama_lengkap')) {
    function nama_lengkap($nama_depan, $nama_tengah, $nama_belakang)
    {
        // nama satu suku kata
        if ($nama_depan == 'NDK' && empty($nama_tengah)) {
            return $nama_belakang;
        }
        // nama depan dan tengah
        else if (empty($nama_tengah)) {
            return $nama_depan . " " . $nama_belakang;
        } else if (!empty($nama_depan) && !empty($nama_tengah) && !empty($nama_belakang)) {
            return $nama_depan . " " . $nama_tengah . " " . $nama_belakang;
        }
    }
}

// Nama Lengkap Kapital Tiap Kata Awal
if (!function_exists('nama_lengkap_ucwords')) {
    function nama_lengkap_ucwords($nama_depan, $nama_tengah, $nama_belakang)
    {
        // nama satu suku kata
        if ($nama_depan == 'NDK' && empty($nama_tengah)) {
            return ucwords(strtolower($nama_belakang));
        }
        // nama depan dan tengah
        else if (empty($nama_tengah)) {
            return ucwords(strtolower($nama_depan . " " . $nama_belakang));
        } else if (!empty($nama_depan) && !empty($nama_tengah) && !empty($nama_belakang)) {
            return ucwords(strtolower($nama_depan . " " . $nama_tengah . " " . $nama_belakang));
        }
    }
}

// Nama Lengkap Kapital SEMUA
if (!function_exists('nama_lengkap_capitalize')) {
    function nama_lengkap_capitalize($nama_depan, $nama_tengah, $nama_belakang)
    {
        // nama satu suku kata
        if ($nama_depan == 'NDK' && empty($nama_tengah)) {
            return strtoupper(strtolower($nama_belakang));
        }
        // nama depan dan tengah
        else if (empty($nama_tengah)) {
            return strtoupper(strtolower($nama_depan . " " . $nama_belakang));
        } else if (!empty($nama_depan) && !empty($nama_tengah) && !empty($nama_belakang)) {
            return strtoupper(strtolower($nama_depan . " " . $nama_tengah . " " . $nama_belakang));
        }
    }
}

// Nama Lengkap Kapital Tiap Kata Awal dan penempatan gelar sesuai
if (!function_exists('nama_gelar_lengkap_ucwords')) {
    function nama_gelar_lengkap_ucwords($nama_depan, $nama_tengah, $nama_belakang, $gelar_depan, $gelar_belakang)
    {
        // nama satu suku kata
        if ($nama_depan == 'NDK' && empty($nama_tengah)) {
            return $gelar_depan . " " . ucwords(strtolower($nama_belakang)) . " " . $gelar_belakang;
        }
        // nama depan dan tengah
        else if (empty($nama_tengah)) {
            return $gelar_depan . " " . ucwords(strtolower($nama_depan . " " . $nama_belakang)) . " " . $gelar_belakang;
        } else if (!empty($nama_depan) && !empty($nama_tengah) && !empty($nama_belakang)) {
            return  $gelar_depan . " " . ucwords(strtolower($nama_depan . " " . $nama_tengah . " " . $nama_belakang)) . " " . $gelar_belakang;
        }
    }
}


// Nama dan  penempatan gelar dibelakang
if (!function_exists('nama_gelar_belakang_ucwords')) {
    function nama_gelar_belakang_ucwords($nama_depan, $nama_tengah, $nama_belakang, $gelar_depan, $gelar_belakang)
    {
        // nama satu suku kata
        if ($nama_depan == 'NDK' && empty($nama_tengah)) {
            return ucwords(strtolower($nama_belakang)) . " " . $gelar_depan . " " . $gelar_belakang;
        }
        // nama depan dan tengah
        else if (empty($nama_tengah)) {
            return  ucwords(strtolower($nama_depan . " " . $nama_belakang)) . " " . $gelar_depan . " " . $gelar_belakang;
        } else if (!empty($nama_depan) && !empty($nama_tengah) && !empty($nama_belakang)) {
            return  ucwords(strtolower($nama_depan . " " . $nama_tengah . " " . $nama_belakang)) . " " . $gelar_depan . " " . $gelar_belakang;
        }
    }
}
