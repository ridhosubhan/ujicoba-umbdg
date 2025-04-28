<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{
    public $db_hrms;

    public function __construct()
    {
        parent::__construct();

        $this->db_hrms = $this->load->database('hrms', TRUE);

        if (($this->session->userdata('logged') != TRUE)
            && ($this->session->userdata('access') != 'payroll_staff')
        ) {
            $url = base_url('login');
            redirect($url);
        };

        $this->load->model('payroll/M_karyawan');
    }

    public function index()
    {
        $data = [
            'title' => "Data Dosen",
            'pegawai' => $this->M_karyawan->get_data_pegawai([
                $this->db_hrms->database . ".pegawai.deleted_at IS NULL" => NULL,
                $this->db_hrms->database . ".ref_status_kepegawaian.id <> 15" => NULL,
                $this->db_hrms->database . ".ref_status_kepegawaian.id <> 3" => NULL,
            ]),

        ];
        $this->load->view('payroll/karyawan/index', $data);
    }
}
