<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_potongan extends CI_Model
{
    public $db_hrms;
    private $db_akademik;

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
        $this->db->select('
                pegawai.id as peg_id, 
                pegawai.gelar_depan,
                pegawai.nama_depan, pegawai.nama_tengah, pegawai.nama_belakang,
                pegawai.gelar_belakang, 
                pegawai.jenis_kelamin,
                pegawai.tmt, 
                pegawai.kat_pegawai, 
                ref_status_kepegawaian.nama as status_kepegawaian,
                trans_jabatan_akademik.id, trans_jabatan_akademik.pegawai_id, trans_jabatan_akademik.akademik_id,
                jabatan_akademik.nama_jabatan, jabatan_akademik.angka_kredit,
                jabatan_struktural.nama_jabatan as nama_jabatan_struktural,
                golongan_pangkat.golongan, golongan_pangkat.pangkat,
                ak_prodi.nama as nama_prodi, 
                ak_fakultas.nama as nama_fakultas,
                divisi.nama as nama_divisi
            ');

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

    public function get_list_potongan($filter = [])
    {
        $this->db->select('
                pegawai.id as peg_id, 
                pegawai.gelar_depan,
                pegawai.nama_depan, pegawai.nama_tengah, pegawai.nama_belakang,
                pegawai.gelar_belakang, 
                pegawai.kat_pegawai, 

                ref_status_kepegawaian.nama as status_kepegawaian,

                gaji_potongan_trans.id as gaji_potongan_trans_id,
                gaji_potongan_trans.bulan,
                gaji_potongan_trans.potongan_ref_id,

                gaji_potongan_ref.id as gaji_potongan_ref_id,
                gaji_potongan_ref.nama as nama_potongan,
                gaji_potongan_ref.keterangan as keterangan_potongan,
                gaji_potongan_ref.nominal,

                gaji_potongan_aktif.id as gaji_potongan_aktif_id,
                gaji_potongan_aktif.is_active,
            ');

        if (!empty($filter)) {
            $this->db->where($filter);
        }

        $this->db->from($this->db_hrms->database . ".pegawai");

        $this->db->join($this->db_hrms->database . ".ref_status_kepegawaian", $this->db_hrms->database . ".ref_status_kepegawaian.id = " . $this->db_hrms->database . ".pegawai.status_kepegawaian");

        $this->db->join(
            $this->db_hrms->database . ".gaji_potongan_trans",
            $this->db_hrms->database . ".gaji_potongan_trans.pegawai_id = " . $this->db_hrms->database . ".pegawai.id"
        );

        $this->db->join(
            $this->db_hrms->database . ".gaji_potongan_ref",
            $this->db_hrms->database . ".gaji_potongan_ref.id = " . $this->db_hrms->database . ".gaji_potongan_trans.potongan_ref_id"
        );

        $this->db->join($this->db_hrms->database . ".gaji_potongan_aktif", $this->db_hrms->database . ".gaji_potongan_aktif.potongan_ref_id = " . $this->db_hrms->database . ".gaji_potongan_ref.id
            AND " .
            $this->db_hrms->database . ".gaji_potongan_aktif.pegawai_id = " . $this->db_hrms->database . ".pegawai.id", "LEFT");

        return  $this->db->get()->result_array();
    }


    public function get_potongan_aktif($pegawai_id)
    {
        return $this->db->select('
                gaji_potongan_ref.id as gaji_potongan_ref_id,
                gaji_potongan_ref.nama,
                gaji_potongan_ref.nominal,
                
                gaji_potongan_aktif.id as gaji_potongan_aktif_id,
                gaji_potongan_aktif.is_active,
                ')
            ->from($this->db_hrms->database . ".gaji_potongan_aktif")

            // ->join($this->db_hrms->database . ".gaji_potongan_trans", $this->db_hrms->database . ".gaji_potongan_trans.potongan_ref_id =" . $this->db_hrms->database . ".gaji_potongan_ref.id")

            ->join($this->db_hrms->database . ".gaji_potongan_ref", $this->db_hrms->database . ".gaji_potongan_ref.id =" . $this->db_hrms->database . ".gaji_potongan_aktif.potongan_ref_id")

            ->where($this->db_hrms->database . ".gaji_potongan_aktif.pegawai_id", $pegawai_id)
            ->where($this->db_hrms->database . ".gaji_potongan_aktif.is_active", 1)
            ->get()->result_array();
    }

    public function profil($id)
    {
        $sql = "
                SELECT 
                    pegawai.*,
                    ref_status_keaktifan.nama as status_keaktifan_nama,
                    ref_status_kepegawaian.nama as status_kepegawaian_nama,
                    ref_agama.nama as agama_nama,
                    trans_jabatan_akademik.id as jad_id, trans_jabatan_akademik.pegawai_id, trans_jabatan_akademik.akademik_id,
                    jabatan_akademik.nama_jabatan, jabatan_akademik.angka_kredit,
                    jabatan_struktural.nama_jabatan as nama_jabatan_struktural,
                    ak_prodi.nama as nama_prodi, 
                    ak_fakultas.nama as nama_fakultas,
                    divisi.nama as nama_divisi,
                    golongan_pangkat.golongan, golongan_pangkat.pangkat,
                    gaji_nominal_person.id as gaji_nominal_person_id, gaji_nominal_person.nominal_gaji,
                    pegawai_rekening.id as rekening_id, pegawai_rekening.bank, pegawai_rekening.no_rekening,
                    pegawai_rekening.keterangan as keterangan_rekening
                FROM " . $this->db_hrms->database . ".pegawai
                JOIN " . $this->db_hrms->database . ".ref_status_keaktifan ON " . $this->db_hrms->database . ".ref_status_keaktifan.id = pegawai.status
                JOIN " . $this->db_hrms->database . ".ref_status_kepegawaian ON " . $this->db_hrms->database . ".ref_status_kepegawaian.id = pegawai.status_kepegawaian
                LEFT JOIN " . $this->db_hrms->database . ".ref_agama ON ref_agama.id = " . $this->db_hrms->database . ".pegawai.agama
                
                LEFT OUTER JOIN " . $this->db_hrms->database . ".trans_jabatan_akademik ON " . $this->db_hrms->database . ".trans_jabatan_akademik.pegawai_id=pegawai.id
                AND " . $this->db_hrms->database . ".trans_jabatan_akademik.id = (SELECT MAX(" . $this->db_hrms->database . ".trans_jabatan_akademik.id) FROM " . $this->db_hrms->database . ".trans_jabatan_akademik
                                                WHERE " . $this->db_hrms->database . ".pegawai.id=" . $this->db_hrms->database . ".trans_jabatan_akademik.pegawai_id)    
                LEFT OUTER JOIN " . $this->db_hrms->database . ".jabatan_akademik ON " . $this->db_hrms->database . ".jabatan_akademik.id=" . $this->db_hrms->database . ".trans_jabatan_akademik.akademik_id 
                
                LEFT OUTER JOIN " . $this->db_hrms->database . ".trans_jabatan_struktural ON " . $this->db_hrms->database . ".trans_jabatan_struktural.pegawai_id=" . $this->db_hrms->database . ".pegawai.id
                AND " . $this->db_hrms->database . ".trans_jabatan_struktural.id = (SELECT MAX(" . $this->db_hrms->database . ".trans_jabatan_struktural.id) FROM " . $this->db_hrms->database . ".trans_jabatan_struktural
                                                WHERE " . $this->db_hrms->database . ".pegawai.id=" . $this->db_hrms->database . ".trans_jabatan_struktural.pegawai_id)    
                LEFT OUTER JOIN " . $this->db_hrms->database . ".jabatan_struktural ON " . $this->db_hrms->database . ".jabatan_struktural.id=" . $this->db_hrms->database . ".trans_jabatan_struktural.struktural_id 
                
                LEFT JOIN ak_prodi ON ak_prodi.id_prodi = " . $this->db_hrms->database . ".pegawai.homebase
                LEFT JOIN ak_fakultas ON ak_fakultas.id_fakultas = ak_prodi.id_fakultas
                LEFT JOIN " . $this->db_hrms->database . ".divisi ON " . $this->db_hrms->database . ".divisi.id = " . $this->db_hrms->database . ".pegawai.homebase
                JOIN " . $this->db_hrms->database . ".golongan_pangkat ON " . $this->db_hrms->database . ".golongan_pangkat.id = " . $this->db_hrms->database . ".pegawai.golongan_dan_pangkat
                LEFT JOIN " . $this->db_hrms->database . ".gaji_nominal_person ON " . $this->db_hrms->database . ".gaji_nominal_person.pegawai_id = " . $this->db_hrms->database . ".pegawai.id
                LEFT JOIN " . $this->db_hrms->database . ".pegawai_rekening ON " . $this->db_hrms->database . ".pegawai_rekening.pegawai_id = " . $this->db_hrms->database . ".pegawai.id
                WHERE " . $this->db_hrms->database . ".pegawai.id = " . $id;
        $query =  $this->db->query($sql);
        return $query->row();
    }

    public function get_tunjangan($id)
    {
        $sql = "
                SELECT 
                    pegawai.id as peg_id,
                    trans_jabatan_akademik.id, trans_jabatan_akademik.pegawai_id, trans_jabatan_akademik.akademik_id,
                    jabatan_akademik.nama_jabatan, jabatan_akademik.angka_kredit, jabatan_akademik.tunjangan as tunjangan_fungsional,
                    
                    jabatan_struktural.nama_jabatan as j_struktural, jabatan_struktural.tunjangan as tunjangan_struktural
                    
                FROM " . $this->db_hrms->database . ".pegawai
                
                LEFT OUTER JOIN " . $this->db_hrms->database . ".trans_jabatan_akademik ON " . $this->db_hrms->database . ".trans_jabatan_akademik.pegawai_id=" . $this->db_hrms->database . ".pegawai.id
                AND " . $this->db_hrms->database . ".trans_jabatan_akademik.id = (SELECT MAX(" . $this->db_hrms->database . ".trans_jabatan_akademik.id) FROM " . $this->db_hrms->database . ".trans_jabatan_akademik
                                                WHERE " . $this->db_hrms->database . ".pegawai.id=" . $this->db_hrms->database . ".trans_jabatan_akademik.pegawai_id)    
                LEFT OUTER JOIN " . $this->db_hrms->database . ".jabatan_akademik ON " . $this->db_hrms->database . ".jabatan_akademik.id=" . $this->db_hrms->database . ".trans_jabatan_akademik.akademik_id 

                LEFT OUTER JOIN " . $this->db_hrms->database . ".trans_jabatan_struktural ON " . $this->db_hrms->database . ".trans_jabatan_struktural.pegawai_id = " . $this->db_hrms->database . ".pegawai.id
                AND " . $this->db_hrms->database . ".trans_jabatan_struktural.id = (SELECT MAX(" . $this->db_hrms->database . ".trans_jabatan_struktural.id) FROM " . $this->db_hrms->database . ".trans_jabatan_struktural
                                                WHERE " . $this->db_hrms->database . ".pegawai.id=" . $this->db_hrms->database . ".trans_jabatan_struktural.pegawai_id) 
                LEFT OUTER JOIN " . $this->db_hrms->database . ".jabatan_struktural ON " . $this->db_hrms->database . ".jabatan_struktural.id=" . $this->db_hrms->database . ".trans_jabatan_struktural.struktural_id 
                
                
                WHERE " . $this->db_hrms->database . ".pegawai.id ='" . $id . "'";
        $query =  $this->db->query($sql);
        return $query->row();
    }
}
