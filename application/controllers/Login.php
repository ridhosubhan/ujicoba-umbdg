<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_login');
    }

    function index()
    {
        $this->load->view('auth/login');
    }

    function autentikasi()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $validasi_email = $this->M_login->query_validasi_email($email);
        if ($validasi_email->num_rows() > 0) {
            $validate_ps = $this->M_login->query_validasi_password($email, $password);
            if ($validate_ps->num_rows() > 0) {
                $x = $validate_ps->row_array();
                if ($x['status'] == 'y') {
                    $tahun = $this->M_login->get_db('ak_tahun', ['status' => 'Y']);
                    $this->session->set_userdata('tahun', $tahun['id_tahun']);
                    $this->session->set_userdata('logged', TRUE);
                    $this->session->set_userdata('user', $email);
                    if ($x['id_akun'] == 'BKU') {
                        $this->session->set_userdata('access', 'TxT');
                        $this->session->set_userdata('id', $x['id_akun']);
                        redirect('administrator');
                    } else if ($x['id_akun'] == 'BKU-PAYROLL') {
                        $this->session->set_userdata('access', 'payroll_staff');
                        $this->session->set_userdata('id', $x['id_akun']);
                        redirect('payroll');
                    } else {
                        $url = base_url('login');
                        echo $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-octagon me-1"></i>
            Maaf. Akses anda ditolak!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>');
                        redirect($url);
                    }
                } else {
                    $url = base_url('login');
                    echo $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-octagon me-1"></i>
            Maaf. Akun anda diblokir!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>');
                    redirect($url);
                }
            } else {
                $url = base_url('login');
                echo $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-octagon me-1"></i>
                Maaf. Password anda salah!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>');
                redirect('login');
            }
        } else {
            $url = base_url('login');
            echo $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-octagon me-1"></i>
            Maaf. Email anda salah!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>');
            redirect('login');
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        $url = base_url('login');
        redirect($url);
    }
}
