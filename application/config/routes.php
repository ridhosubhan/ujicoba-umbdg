<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//============= STATUS =============//
$route['cek-status'] = 'status/cek_status';
$route['cek-status/(:num)/detail'] = 'status/cek_status/$1';
$route['cek-status-mahasiswa'] = 'status/cek_status_mahasiswa';
$route['cek-status-mahasiswa/(:num)'] = 'status/cek_status_mahasiswa/$1';

//============= MASTER =============//
$route['administrator'] = 'admin/Administrator/index';
// Akun
$route['administrator/master/akun'] = 'admin/Administrator/akun';
// Pos Tagihan
$route['administrator/master/pos-tagihan'] = 'admin/Administrator/pos_tagihan';
// Portal KRS
$route['administrator/master/portal-krs'] = 'admin/Administrator/portal/krs';
$route['administrator/master/portal-krs/(:any)'] = 'admin/Administrator/portal/krs/$1';
$route['administrator/master/portal-krs/(:any)/(:num)'] = 'admin/Administrator/portal/krs/$1/$2';
// Portal UTS
$route['administrator/master/portal-uts'] = 'admin/Administrator/portal/uts';
$route['administrator/master/portal-uts/(:any)'] = 'admin/Administrator/portal/uts/$1';
$route['administrator/master/portal-uts/(:any)/(:num)'] = 'admin/Administrator/portal/uts/$1/$2';
// Portal UAS
$route['administrator/master/portal-uas'] = 'admin/Administrator/portal/uas';
$route['administrator/master/portal-uas/(:any)'] = 'admin/Administrator/portal/uas/$1';
$route['administrator/master/portal-uas/(:any)/(:num)'] = 'admin/Administrator/portal/uas/$1/$2';

//============= PENERIMAAN =============//
// PMB
$route['administrator/penerimaan/pmb/registrasi'] = 'admin/penerimaan/Penerimaan/pmb/Registrasi';
$route['administrator/penerimaan/pmb/daftar-ulang'] = 'admin/penerimaan/Penerimaan/pmb/Daftar Ulang';
// UKT
$route['administrator/penerimaan/ukt'] = 'admin/penerimaan/Penerimaan/ukt';
$route['administrator/penerimaan/ukt/(:any)'] = 'admin/penerimaan/Penerimaan/ukt/$1';
$route['administrator/penerimaan/ukt/rincian/(:num)'] = 'admin/penerimaan/Penerimaan/rincian_ukt/$1';
// Pos Tagihan
$route['administrator/penerimaan/pos-tagihan'] = 'admin/penerimaan/Penerimaan/pos_tagihan';
$route['administrator/penerimaan/pos-tagihan/rincian/(:num)'] = 'admin/penerimaan/Penerimaan/rincian_pos_tagihan/$1';
$route['administrator/penerimaan/pos-tagihan/rincian/(:num)/(:any)'] = 'admin/penerimaan/Penerimaan/rincian_pos_tagihan/$1/$2';
// Beasiswa
$route['administrator/penerimaan/beasiswa/baznas-kota-bandung'] = 'admin/penerimaan/Penerimaan/beasiswa/1';
$route['administrator/penerimaan/beasiswa/baznas-ri'] = 'admin/penerimaan/Penerimaan/beasiswa/2';
$route['administrator/penerimaan/beasiswa/dakwah-keumatan'] = 'admin/penerimaan/Penerimaan/beasiswa/3';
$route['administrator/penerimaan/beasiswa/guru'] = 'admin/penerimaan/Penerimaan/beasiswa/4';
$route['administrator/penerimaan/beasiswa/hafizh'] = 'admin/penerimaan/Penerimaan/beasiswa/5';
$route['administrator/penerimaan/beasiswa/kader-muhammadiyah'] = 'admin/penerimaan/Penerimaan/beasiswa/6';
$route['administrator/penerimaan/beasiswa/kip'] = 'admin/penerimaan/Penerimaan/beasiswa/7';
$route['administrator/penerimaan/beasiswa/lazismu-kl'] = 'admin/penerimaan/Penerimaan/beasiswa/8';
$route['administrator/penerimaan/beasiswa/prestasi'] = 'admin/penerimaan/Penerimaan/beasiswa/9';

//============= PAYROLL =============//
$route['payroll'] = 'admin/payroll/PayrollDashboard/index';
// Referensi Potongan
$route['administrator/payroll/referensi-potongan'] = 'admin/payroll/ReferensiPotongan/index';
$route['administrator/payroll/referensi-potongan/store'] = 'admin/payroll/ReferensiPotongan/store';
$route['administrator/payroll/referensi-potongan/edit'] = 'admin/payroll/ReferensiPotongan/edit';
$route['administrator/payroll/referensi-potongan/update'] = 'admin/payroll/ReferensiPotongan/update';
$route['administrator/payroll/referensi-potongan/destroy'] = 'admin/payroll/ReferensiPotongan/destroy';

// Potongan
$route['administrator/payroll/potongan'] = 'admin/payroll/potongan/CorePotongan/index';
$route['administrator/payroll/potongan/detail/(:num)'] = 'admin/payroll/potongan/CorePotongan/detail/$1';
$route['administrator/payroll/potongan/add-potongan'] = 'admin/payroll/potongan/CorePotongan/add_potongan';
$route['administrator/payroll/potongan/destroy-potongan'] = 'admin/payroll/potongan/CorePotongan/destroy_potongan';
// Upload Potongan
$route['administrator/payroll/potongan/upload'] = 'admin/payroll/potongan/UploadPotongan/index';
$route['administrator/payroll/potongan/upload-template'] = 'admin/payroll/potongan/UploadPotongan/export_template_potongan';
$route['administrator/payroll/potongan/upload-store'] = 'admin/payroll/potongan/UploadPotongan/upload_excel';
// Potongan List
$route['administrator/payroll/potongan/list'] = 'admin/payroll/potongan/PotonganList/index';
$route['administrator/payroll/sync-potongan'] = 'admin/payroll/potongan/PotonganList/sinkron_potongan';
// Cron Potongan
$route['api/cron/payroll/sync-potongan']['POST'] = 'admin/payroll/potongan/CronPotongan/api_cron_potongan';

// Rekening
$route['administrator/payroll/potongan/get-rekening'] = 'admin/payroll/potongan/CorePotongan/get_rekening';
$route['administrator/payroll/potongan/update-rekening'] = 'admin/payroll/potongan/CorePotongan/update_rekening';
// Gaji
$route['administrator/payroll/gaji'] = 'admin/payroll/Gaji/gaji';
$route['administrator/payroll/gaji/index/(:num)/(:any)'] = 'admin/payroll/Gaji/gaji_index/$1/$2';
$route['administrator/payroll/gaji/detail-potongan'] = 'admin/payroll/Gaji/detail_potongan';
$route['administrator/payroll/gaji/generate/(:num)/(:any)'] = 'admin/payroll/Gaji/gaji_generate/$1/$2';
$route['administrator/payroll/gaji/export-excel/(:num)/(:any)'] = 'admin/payroll/Gaji/export_excel/$1/$2';
$route['administrator/payroll/gaji/export-payroll/(:num)/(:any)'] = 'admin/payroll/Gaji/export_payroll/$1/$2';
// Gaji
$route['administrator/payroll/rapel-gaji'] = 'admin/payroll/RapelGaji/gaji';
$route['administrator/payroll/rapel-gaji/index/(:num)'] = 'admin/payroll/RapelGaji/gaji_index/$1';
$route['administrator/payroll/rapel-gaji/store'] = 'admin/payroll/RapelGaji/store';
$route['administrator/payroll/rapel-gaji/export-excel/(:num)'] = 'admin/payroll/RapelGaji/export_excel/$1';
$route['administrator/payroll/rapel-gaji/export-payroll/(:num)'] = 'admin/payroll/RapelGaji/export_payroll/$1';
// Slip Gaji
$route['administrator/payroll/cetak-slip-gaji/(:any)/(:any)'] = 'admin/payroll/Gaji/cetak_slip_mpdf/$1/$2';
$route['administrator/payroll/cetak-slip-gaji-excel/(:any)/(:any)'] = 'admin/payroll/Gaji/cetak_slip_excel/$1/$2';
// Karyawan
$route['administrator/payroll/karyawan'] = 'admin/payroll/Karyawan/index';

//============= AUTH =============//
$route['logout'] = 'Login/logout';





// API Untuk KKN
$route['api/check-krs']['POST'] = 'API/ApiKKN/check_krs';
