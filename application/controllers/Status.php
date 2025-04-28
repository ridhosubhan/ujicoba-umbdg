<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ngekoding\CodeIgniterDataTables\DataTables;

class Status extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('M_status');
    }

    public function cek_status($id_jadwal = '')
    {
        if ($id_jadwal === '') {
            $this->load->view('status/cek_status', [
                'list_jadwal' => $this->M_status->get_status(),
            ]);
        } else {
            $this->load->view('status/detail_status', [
                'jadwal' => $this->M_status->get_jadwal($id_jadwal),
            ]);
        }
    }

    public function cek_status_mahasiswa()
    {
        $this->load->view('status/detail_mahasiswa');
    }

    public function get_status()
    {
        $query = $this->M_status->get_status();

        $datatables = new DataTables($query, '3');
        $datatables
            ->asObject()
            ->addSequenceNumber('nomor')
            ->generate();
    }

    public function get_mahasiswa($nim = '')
    {
        $query = $this->M_status->get_mahasiswa($nim);

        $datatables = new DataTables($query, '3');
        $datatables
            ->asObject()
            ->addSequenceNumber('nomor')
            ->generate();
    }

    public function get_list_mahasiswa($id_jadwal = '')
    {
        $query = $this->M_status->get_list_mahasiswa($id_jadwal);

        $datatables = new DataTables($query, '3');
        $datatables
            ->asObject()
            ->addSequenceNumber('nomor')
            ->generate();
    }
}
