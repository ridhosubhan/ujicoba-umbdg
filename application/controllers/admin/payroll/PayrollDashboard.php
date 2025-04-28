<?php
defined('BASEPATH') or exit('No direct script access allowed');


class PayrollDashboard extends CI_Controller
{
    public $db_hrms;

    public function __construct()
    {
        parent::__construct();

        $this->db_hrms = $this->load->database('hrms', TRUE);

        if (($this->session->userdata('logged') != TRUE)
            || ($this->session->userdata('access') != 'payroll_staff')
        ) {
            $url = base_url('login');
            redirect($url);
        };

        $this->load->model('admin/M_administrator', 'M_administrator');
    }

    public function index()
    {
        $data = ([
            'tahun' => $this->M_administrator->get_db('ak_tahun', ['status' => 'Y'])
        ]);

        $this->load->view('payroll/dashboard', $data);
    }
}
