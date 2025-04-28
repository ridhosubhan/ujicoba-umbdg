<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('application/controllers/Layout.php');

class Administrator extends Layout
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->layout('admin/dashboard', [
            'tahun' => $this->M_administrator->get_db('ak_tahun', ['status' => 'Y'])
        ]);
    }

    public function portal($type, $prodi = '', $tahun = '')
    {
        if ($prodi === '') {
            $prodi = 'AG';
        }

        if ($tahun === '') {
            $tahun_aktif = $this->M_administrator->get_db('ak_tahun', ['status' => 'Y']);
            $tahun = $tahun_aktif['id_tahun'];
        }

        $list_mahasiswa = $this->M_administrator->get_db('ak_mahasiswa', ['id_prodi' => $prodi], 'result');
        $temp_mahasiswa = [];

        if ($tahun === $this->session->tahun) {
            $temp_mahasiswa = $list_mahasiswa;

            $Y = $this->M_administrator->get_db_count('ak_mahasiswa', ['id_prodi' => $prodi, $type => 'Y']);
            $N = $this->M_administrator->get_db_count('ak_mahasiswa', ['id_prodi' => $prodi, $type => 'N']);
        } else {
            foreach ($list_mahasiswa as $mahasiswa) {
                $history_status = $this->M_administrator->get_db('ak_history_status', [
                    'nim' => $mahasiswa['nim'],
                    'id_tahun' => $tahun
                ]);

                if (!empty($history_status)) {
                    $temp_mahasiswa[] = [
                        'nim' => $mahasiswa['nim'],
                        'nama' => $mahasiswa['nama'],
                        'tahun_angkatan' => $mahasiswa['tahun_angkatan'],
                        $type => $history_status[$type]
                    ];
                }
            }

            $Y = $this->M_administrator->jumlah_history_status($prodi, $type, 'Y', $tahun);
            $N = $this->M_administrator->jumlah_history_status($prodi, $type, 'N', $tahun);
        }

        $this->layout('admin/portal', [
            'prodi' => $this->M_administrator->get_db('ak_prodi', ['id_prodi' => $prodi]),
            'Y' => $Y,
            'N' => $N,
            'type' => $type,
            'list_mahasiswa' => $temp_mahasiswa,
            'list_prodi' => $this->M_administrator->get_db('ak_prodi', ['kelas' => 'Reguler'], 'result'),
            'list_tahun' => $this->M_administrator->get_db('ak_tahun')
        ]);
    }

    public function ubah_prodi($type, $tahun = '')
    {
        if ($tahun === '') {
            $tahun_aktif = $this->M_administrator->get_db('ak_tahun', ['status' => 'Y']);
            $tahun = $tahun_aktif['id_tahun'];
        }

        $prodi = $this->input->post('prodi');
        redirect("administrator/master/portal-$type/$prodi/$tahun");
    }

    public function ubah_tahun($type, $prodi = '')
    {
        if ($prodi === '') {
            $prodi = 'AG';
        }

        $tahun = $this->input->post('tahun');
        redirect("administrator/master/portal-$type/$prodi/$tahun");
    }

    function aktifator($type, $nim, $id_prodi, $tahun = '')
    {
        if ($tahun === '') {
            $tahun_aktif = $this->M_administrator->get_db('ak_tahun', ['status' => 'Y']);
            $tahun = $tahun_aktif['id_tahun'];
        }

        $this->M_administrator->aktifator($type, $nim, $tahun);
        redirect("administrator/master/portal-$type/$id_prodi/$tahun");
    }

    public function akun()
    {
        $this->layout('admin/akun', [
            'list_akun' => $this->M_administrator->get_db_keuangan_sias('ref_akun_detail')
        ]);
    }

    public function pos_tagihan()
    {
        $this->layout('admin/pos_tagihan', [
            'list_pos' => $this->M_administrator->get_db_keuangan_payment('ref_pos_tagihan')
        ]);
    }
}
