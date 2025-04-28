<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{

    public function get_db($table, $data = null, $type = 'row')
    {
        if ($data === null) return $this->db->get($table)->result_array();
        elseif ($type === 'row') return $this->db->get_where($table, $data)->row_array();
        elseif ($type === 'result') return $this->db->get_where($table, $data)->result_array();
    }

    function query_validasi_email($email) {
        $hrms = $this->load->database('hrms', TRUE);
        $result = $hrms->query("SELECT * FROM akun WHERE username='$email' LIMIT 1");
        return $result;
    }

    function query_validasi_password($email, $password) {
        $hrms = $this->load->database('hrms', TRUE);
        $result = $hrms->query("SELECT * FROM akun WHERE username='$email' AND password=SHA2('$password', 224) LIMIT 1");
        return $result;
    }

    function query_get_data_dosen($email)
    {
        $this->db->select('
            pegawai.gelar_depan, pegawai.gelar_belakang,
            pegawai.nama_depan, pegawai.nama_tengah, pegawai.nama_belakang,
            pegawai.homebase
            ');
        $this->db->from('pegawai');
        $this->db->where('pegawai.email_kampus', $email);

        $query = $this->db->get();
        return $query->row();
    }
}
