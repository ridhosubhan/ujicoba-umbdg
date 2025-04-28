<?php
defined('BASEPATH') or exit('No direct script access allowed');

$autoload['packages']  = [];
$autoload['libraries'] = ['database', 'form_validation', 'parser', 'session'];
$autoload['drivers']   = [];
$autoload['helper']    = [
    'cookie', 'file', 'form', 'format_rupiah_helper', 'nama_lengkap',
    'tanggal_indonesia', 'url', 'url_helper'
];
$autoload['config']    = [];
$autoload['language']  = [];
$autoload['model']     = [];
