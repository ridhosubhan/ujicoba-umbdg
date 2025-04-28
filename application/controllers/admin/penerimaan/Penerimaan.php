<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('application/controllers/Layout.php');

class Penerimaan extends Layout
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('admin/penerimaan/M_penerimaan', 'M_penerimaan');
    }

    //============= PMB =============//
    public function pmb($nama_tagihan)
    {
        $list_tagihan = $this->M_administrator->get_db_keuangan_payment('tb_tagihan', ['BILLNM' => $nama_tagihan], 'result');

        $this->layout('admin/penerimaan/pmb', [
            'jenis_pmb' => $nama_tagihan,
            'list_prodi' => $this->M_penerimaan->get_prodi_order_by_fakultas(),
            'list_tagihan' => $list_tagihan
        ]);
    }

    //============= UKT =============//
    public function ukt($prodi_pilihan = '')
    {
        $list_prodi = $this->M_penerimaan->get_prodi_order_by_fakultas();
        $list_ukt = $this->M_penerimaan->get_ukt();
        $ukt_per_mahasiswa = [];
        $ukt_per_prodi = [];
        $i = 0;

        if ($prodi_pilihan === '') {
            $list_mahasiswa = $this->M_penerimaan->get_db('ak_mahasiswa', ['id_prodi' => 'AG'], 'result');
            $prodi_pilihan = $this->M_penerimaan->get_db('ak_prodi', ['id_prodi' => 'AG']);
        } elseif ($prodi_pilihan === 'all') {
            $list_mahasiswa = $this->M_penerimaan->get_db('ak_mahasiswa');
        } else {
            $list_mahasiswa = $this->M_penerimaan->get_db('ak_mahasiswa', ['id_prodi' => $prodi_pilihan], 'result');
            $prodi_pilihan = $this->M_penerimaan->get_db('ak_prodi', ['id_prodi' => $prodi_pilihan]);
        }

        foreach ($list_ukt as $ukt) {
            $ukt_per_mahasiswa[$ukt['NOCUST']]['total_tagihan'] = $ukt['BILLAM'];
            $ukt_per_mahasiswa[$ukt['NOCUST']]['total_pembayaran'] = $ukt['PAIDAM'];
        }

        foreach ($list_prodi as $prodi) {
            $list_mahasiswa_per_prodi = $this->M_penerimaan->get_db('ak_mahasiswa', ['id_prodi' => $prodi['id_prodi']], 'result');

            $ukt_per_prodi[$i]['nama_prodi'] = $prodi['nama'];
            $ukt_per_prodi[$i]['tagihan'] = 0;
            $ukt_per_prodi[$i]['pembayaran'] = 0;

            foreach ($list_ukt as $ukt) {
                foreach ($list_mahasiswa_per_prodi as $mahasiswa) {
                    if ($ukt['NOCUST'] === $mahasiswa['nim']) {
                        $ukt_per_prodi[$i]['tagihan'] += intval($ukt['BILLAM']);
                        $ukt_per_prodi[$i]['pembayaran'] += intval($ukt['PAIDAM']);
                    }
                }
            }

            $i++;
        }

        $this->layout('admin/penerimaan/ukt', [
            'prodi_pilihan' => $prodi_pilihan,
            'ukt_per_mahasiswa' => $ukt_per_mahasiswa,
            'list_mahasiswa' => $list_mahasiswa,
            'list_prodi' => $list_prodi,
            'list_ukt_per_prodi' => $ukt_per_prodi
        ]);
    }

    public function rincian_ukt($nim)
    {
        $list_ukt = $this->M_penerimaan->get_ukt_mahasiswa($nim);
        $id_transaksi = $this->M_administrator->get_db_keuangan_payment('umbandung_payment.tb_transaksi', ['NOCUST' => $nim]);
        $list_transaksi = $this->M_administrator->get_db_keuangan_payment('umbandung_payment.tb_transaksi', ['id_cust' => $id_transaksi['id_cust']], 'result');
        $saldo = 0;

        if (!empty($list_transaksi)) {
            foreach ($list_transaksi as $transaksi) {
                if ($transaksi['DEBET'] == 0) {
                    $saldo += $transaksi['KREDIT'];
                } elseif ($transaksi['KREDIT'] == 0) {
                    $saldo -= $transaksi['DEBET'];
                }
            }
        }

        $ukt_mahasiswa = [];
        $i = 0;

        foreach ($list_ukt as $ukt) {
            $ukt_mahasiswa[$i]['kode_akun'] = $ukt['KODE_AKUN'];
            $ukt_mahasiswa[$i]['semester'] = $ukt['SEMESTER'];
            $ukt_mahasiswa[$i]['jenis_tagihan'] = $ukt['BILLNM'];
            $ukt_mahasiswa[$i]['tagihan'] = $ukt['BILLAM'];
            $ukt_mahasiswa[$i]['pembayaran'] = $ukt['PAIDAM'];
            $ukt_mahasiswa[$i]['status_bayar'] = $ukt['PAIDST'];
            $ukt_mahasiswa[$i]['tanggal_bayar'] = $ukt['PAIDDT'];
            $ukt_mahasiswa[$i]['metode_pembayaran'] = $ukt['PAIDBY'];

            $i++;
        }

        $this->layout('admin/penerimaan/rincian_ukt', [
            'mahasiswa' => $this->M_penerimaan->get_db('ak_mahasiswa', ['nim' => $nim]),
            'saldo' => $saldo,
            'ukt_mahasiswa' => $ukt_mahasiswa
        ]);
    }

    //============= POS TAGIHAN =============//
    public function pos_tagihan()
    {
        $this->layout('admin/penerimaan/pos_tagihan', [
            'list_pos' => $this->M_penerimaan->get_total_per_pos()
        ]);
    }

    public function rincian_pos_tagihan($pos_tagihan, $prodi_pilihan = '')
    {
        $list_pos = $this->M_penerimaan->get_rincian_per_pos($pos_tagihan);
        $rincian_per_pos = [];

        if ($prodi_pilihan === '') {
            $list_mahasiswa = $this->M_penerimaan->get_db('ak_mahasiswa', ['id_prodi' => 'AG'], 'result');
            $prodi_pilihan = $this->M_penerimaan->get_db('ak_prodi', ['id_prodi' => 'AG']);
        } elseif ($prodi_pilihan === 'all') {
            $list_mahasiswa = $this->M_penerimaan->get_db('ak_mahasiswa');
        } else {
            $list_mahasiswa = $this->M_penerimaan->get_db('ak_mahasiswa', ['id_prodi' => $prodi_pilihan], 'result');
            $prodi_pilihan = $this->M_penerimaan->get_db('ak_prodi', ['id_prodi' => $prodi_pilihan]);
        }

        foreach ($list_pos as $pos) {
            $rincian_per_pos[$pos['NOCUST']]['tagihan'] = $pos['BILLAM'];
            $rincian_per_pos[$pos['NOCUST']]['pembayaran'] = $pos['PAIDAM'];
        }

        $this->layout('admin/penerimaan/rincian_pos_tagihan', [
            'pos_tagihan' => $this->M_administrator->get_db_keuangan_payment('ref_pos_tagihan', ['kode' => $pos_tagihan]),
            'prodi_pilihan' => $prodi_pilihan,
            'rincian_per_pos' => $rincian_per_pos,
            'list_mahasiswa' => $list_mahasiswa,
            'list_prodi' => $this->M_penerimaan->get_prodi_order_by_fakultas()
        ]);
    }

    //============= BEASISWA =============//
    public function beasiswa($id_beasiswa)
    {
        $list_beasiswa = $this->M_administrator->get_db_keuangan_payment('tb_beasiswa', ['id_beasiswa' => $id_beasiswa], 'result');
        $list_mahasiswa = [];

        foreach ($list_beasiswa as $beasiswa) {
            $mahasiswa = $this->M_penerimaan->get_db('ak_mahasiswa', ['nim' => $beasiswa['NOCUST']]) ?
                $this->M_penerimaan->get_db('ak_mahasiswa', ['nim' => $beasiswa['NOCUST']]) : null;

            if ($mahasiswa == null) continue;

            $list_mahasiswa[$mahasiswa['nim']]['nama'] = $mahasiswa['nama'];
            $list_mahasiswa[$mahasiswa['nim']]['id_prodi'] = $mahasiswa['id_prodi'];
        }

        $this->layout('admin/penerimaan/beasiswa', [
            'jenis_beasiswa' => $this->M_administrator->get_db_keuangan_payment('ref_beasiswa', ['id' => $id_beasiswa]),
            'list_beasiswa' => $list_beasiswa,
            'list_mahasiswa' => $list_mahasiswa,
            'list_prodi' => $this->M_penerimaan->get_prodi_order_by_fakultas()
        ]);
    }

    //============= UTILITIES =============//
    public function ubah_prodi($one, $two = '', $three = '')
    {
        if ($two === '') redirect('administrator/penerimaan/' . $one . '/' . $this->input->post('prodi'));
        elseif ($three === '') redirect('administrator/penerimaan/' . $one . '/' . $two . '/' . $this->input->post('prodi'));
        else redirect('administrator/penerimaan/' . $one . '/' . $two . '/' . $three . '/' . $this->input->post('prodi'));
    }
}
