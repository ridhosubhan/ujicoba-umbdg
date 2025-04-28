<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SlipGajiPDF extends CI_Controller
{
    public $db_hrms;
    public $db_akademik;

    public function __construct()
    {
        parent::__construct();

        $this->db_hrms = $this->load->database('hrms', TRUE);
        $this->db_akademik = $this->load->database('akademik', TRUE);

        if (($this->session->userdata('logged') != TRUE)
            || ($this->session->userdata('access') != 'payroll_staff')
        ) {
            $url = base_url('login');
            redirect($url);
        };

        $this->load->model('payroll/M_gaji');
    }

    public function cetak_slip_mpdf($bulan, $pegawai_id)
    {
        $this->load->library('MpdfGenerator');

        // title dari pdf
        $this->data['title'] = 'Slip Gaji';

        // detail pegawai
        $this->data['data_pegawai'] = $this->M_gaji->slip_gaji_dosen($bulan, $pegawai_id);

        $this->data['data_remun_dosen'] = ([
            'bulan' => $bulan,

            'nama_lengkap' => nama_gelar_lengkap_ucwords(
                $this->data['data_pegawai']->nama_depan,
                $this->data['data_pegawai']->nama_tengah,
                $this->data['data_pegawai']->nama_belakang,
                $this->data['data_pegawai']->gelar_depan,
                $this->data['data_pegawai']->gelar_belakang
            ),
            'tanggal' => tanggal_indonesia(date('Y-m-d'))
        ]);

        $this->data['data_kehadiran_single'] = $this->M_gaji->data_kehadiran_single($pegawai_id, $bulan);
        $this->data['data_lembur_single'] = $this->M_gaji->data_lembur_single($pegawai_id, $bulan);

        // var_dump($this->data['data_lembur_single']);
        // exit;

        $this->data['data_potongan'] = $this->db->select("
                " . $this->db_hrms->database . ".gaji_potongan_ref.id as id_potongan,
                " . $this->db_hrms->database . ".gaji_potongan_ref.nama,
                " . $this->db_hrms->database . ".gaji_potongan_ref.nominal
                ")
            ->from($this->db_hrms->database . ".gaji_potongan_ref")
            ->join($this->db_hrms->database . ".gaji_potongan_trans", $this->db_hrms->database . ".gaji_potongan_trans.potongan_ref_id =" . $this->db_hrms->database . ".gaji_potongan_ref.id")
            ->where($this->db_hrms->database . ".gaji_potongan_trans.pegawai_id", $pegawai_id)
            // ->where('gaji_potongan_trans.bulan', $bulan)
            ->get()
            ->result_array();

        $this->data['total_potongan'] = $this->db->select("
                        SUM(" . $this->db_hrms->database . ".gaji_potongan_ref.nominal) as nominal_potongan,
                    ")
            ->from($this->db_hrms->database . ".gaji_potongan_ref")
            ->join($this->db_hrms->database . ".gaji_potongan_trans", $this->db_hrms->database . ".gaji_potongan_trans.potongan_ref_id =" . $this->db_hrms->database . ".gaji_potongan_ref.id")
            ->where($this->db_hrms->database . ".gaji_potongan_trans.pegawai_id", $pegawai_id)
            // ->where('gaji_potongan_trans.bulan', $bulan)
            ->get()->row();

        // filename dari pdf ketika didownload
        $file_pdf = 'slip gaji';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";

        $html = $this->load->view('payroll/gaji/slip_gaji', $this->data, true);

        $nama_file = 'Slip Gaji - ' . $this->data['data_remun_dosen']["nama_lengkap"] . ' - ' . $bulan . '.pdf';

        // run mpdf
        $this->mpdfgenerator->generate($html, $nama_file);
    }
}
