<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_karyawan extends CI_Model
{
    public $db_hrms;
    public $db_akademik;

    public function __construct()
    {
        parent::__construct();

        $this->db_hrms = $this->load->database('hrms', TRUE);
        $this->db_akademik = $this->load->database('akademik', TRUE);
    }

    public function get_db($database, $data = [null], $type = 'row')
    {
        if ($data === [null]) return $this->db_hrms->get($database)->result_array();
        elseif ($type === 'row') return $this->db_hrms->get_where($database, $data)->row_array();
        elseif ($type === 'result') return $this->db_hrms->get_where($database, $data)->result_array();
    }

    public function insert($data, $table_db)
    {
        if (!empty($data) && !empty($table_db)) {
            return $this->db_hrms->insert($table_db, $data);
        }
    }

    public function update($data, $param, $table_db)
    {
        if (!empty($data) && !empty($param) && is_array($param) && !empty($table_db)) {
            return $this->db_hrms->update($table_db, $data, $param);
        }
    }

    public function delete($param, $table_db)
    {
        if (!empty($param) && is_array($param) && !empty($table_db)) {
            return $this->db_hrms->delete($table_db, $param);
        }
    }

    public function get_data_pegawai($filter = [])
    {
        $this->db->select(
            $this->db_hrms->database . ".pegawai.id as peg_id, 
            " . $this->db_hrms->database . ".pegawai.nik, 
                " . $this->db_hrms->database . ".pegawai.gelar_depan,
                " . $this->db_hrms->database . ".pegawai.nama_depan, 
                " . $this->db_hrms->database . ".pegawai.nama_tengah, 
                " . $this->db_hrms->database . ".pegawai.nama_belakang,
                " . $this->db_hrms->database . ".pegawai.gelar_belakang, 
                " . $this->db_hrms->database . ".pegawai.jenis_kelamin, 
                " . $this->db_hrms->database . ".pegawai.tempat_lahir, 
                " . $this->db_hrms->database . ".pegawai.tanggal_lahir, 
                " . $this->db_hrms->database . ".pegawai.alamat, 
                " . $this->db_hrms->database . ".pegawai.kontak, 
                " . $this->db_hrms->database . ".pegawai.status_pernikahan, 
                " . $this->db_hrms->database . ".pegawai.email_pribadi, 
                " . $this->db_hrms->database . ".pegawai.email_kampus, 
                " . $this->db_hrms->database . ".pegawai.nidn_nidk_nitk,
                " . $this->db_hrms->database . ".pegawai.tmt, 
                " . $this->db_hrms->database . ".pegawai.no_npwp, 
                
                " . $this->db_hrms->database . ".ref_status_kepegawaian.nama as status_kepegawaian,
                
                " . $this->db_hrms->database . ".trans_jabatan_akademik.id, trans_jabatan_akademik.pegawai_id, trans_jabatan_akademik.akademik_id,
                " . $this->db_hrms->database . ".jabatan_akademik.nama_jabatan, 
                " . $this->db_hrms->database . ".jabatan_akademik.angka_kredit,
                
                " . $this->db_hrms->database . ".jabatan_struktural.nama_jabatan as nama_jabatan_struktural,
                    
                " . $this->db_hrms->database . ".golongan_pangkat.golongan, 
                " . $this->db_hrms->database . ".golongan_pangkat.pangkat,
                    
                `" . $this->db_akademik->database . "`.`ak_prodi`.`nama` as `nama_prodi`, 
                `" . $this->db_akademik->database . "`.`ak_fakultas`.`nama` as `nama_fakultas`,

                " . $this->db_hrms->database . ".divisi.nama as nama_divisi"
        );

        if (!empty($filter)) {
            $this->db->where($filter);
        }

        $this->db->from($this->db_hrms->database . ".pegawai");

        $this->db->join($this->db_hrms->database . ".ref_status_kepegawaian", $this->db_hrms->database . ".ref_status_kepegawaian.id = " . $this->db_hrms->database . ".pegawai.status_kepegawaian");

        $this->db->join($this->db_hrms->database . ".trans_jabatan_akademik",  $this->db_hrms->database . ".trans_jabatan_akademik.pegawai_id=pegawai.id AND " . $this->db_hrms->database . ".trans_jabatan_akademik.id = (SELECT MAX(" . $this->db_hrms->database . ".trans_jabatan_akademik.id) FROM " . $this->db_hrms->database . ".trans_jabatan_akademik WHERE " . $this->db_hrms->database . ".pegawai.id=" . $this->db_hrms->database . ".trans_jabatan_akademik.pegawai_id)", 'LEFT OUTER');
        $this->db->join($this->db_hrms->database . ".jabatan_akademik",  $this->db_hrms->database . ".jabatan_akademik.id=" . $this->db_hrms->database . ".trans_jabatan_akademik.akademik_id", "LEFT");

        $this->db->join($this->db_hrms->database . ".trans_jabatan_struktural",  $this->db_hrms->database . ".trans_jabatan_struktural.pegawai_id=pegawai.id AND " . $this->db_hrms->database . ".trans_jabatan_struktural.id = (SELECT MAX(" . $this->db_hrms->database . ".trans_jabatan_struktural.id) FROM " . $this->db_hrms->database . ".trans_jabatan_struktural WHERE " . $this->db_hrms->database . ".pegawai.id=" . $this->db_hrms->database . ".trans_jabatan_struktural.pegawai_id)", 'LEFT OUTER');
        $this->db->join($this->db_hrms->database . ".jabatan_struktural",  $this->db_hrms->database . ".jabatan_struktural.id=" . $this->db_hrms->database . ".trans_jabatan_struktural.struktural_id", "LEFT");

        $this->db->join($this->db_akademik->database . ".ak_prodi", $this->db_akademik->database . ".ak_prodi.id_prodi = " . $this->db_hrms->database . ".pegawai.homebase", "LEFT");
        $this->db->join($this->db_akademik->database . ".ak_fakultas", $this->db_akademik->database . ".ak_fakultas.id_fakultas = " . $this->db_akademik->database . ".ak_prodi.id_fakultas", "LEFT");

        $this->db->join($this->db_hrms->database . ".divisi", $this->db_hrms->database . ".divisi.id = " . $this->db_hrms->database . ".pegawai.homebase", "LEFT");
        $this->db->join($this->db_hrms->database . ".golongan_pangkat", $this->db_hrms->database . ".golongan_pangkat.id = " . $this->db_hrms->database . ".pegawai.golongan_dan_pangkat");

        $query = $this->db->get()->result_array();
        return $query;
    }
}
