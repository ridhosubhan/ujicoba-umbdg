<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_rapelgaji extends CI_Model
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

    public function delete($param, $table_db)
    {
        if (!empty($param) && is_array($param) && !empty($table_db)) {
            return $this->db_hrms->delete($table_db, $param);
        }
    }

    public function cek_gaji($filter = [])
    {
        if (array_key_exists($this->db_hrms->database . ".gaji_generate.bulan", $filter) || array_key_exists($this->db_hrms->database . ".bulan", $filter)) {
            $this->db->select(
                $this->db_hrms->database . ".pegawai.id as peg_id, 
                    " . $this->db_hrms->database . ".pegawai.nip, pegawai.nama_depan, 
                    " . $this->db_hrms->database . ".pegawai.nama_tengah, 
                    " . $this->db_hrms->database . ".pegawai.nama_belakang,
                    " . $this->db_hrms->database . ".pegawai.gelar_depan, 
                    " . $this->db_hrms->database . ".pegawai.gelar_belakang, 
                    " . $this->db_hrms->database . ".pegawai.tmt, 
                    " . $this->db_hrms->database . ".pegawai.status_kepegawaian, 
                    " . $this->db_hrms->database . ".pegawai.nidn_nidk_nitk,
                        
                    " . $this->db_hrms->database . ".trans_jabatan_akademik.id, 
                    " . $this->db_hrms->database . ".trans_jabatan_akademik.pegawai_id, 
                    " . $this->db_hrms->database . ".trans_jabatan_akademik.akademik_id,
                    " . $this->db_hrms->database . ".jabatan_akademik.nama_jabatan, 
                    " . $this->db_hrms->database . ".jabatan_akademik.angka_kredit, 
                    " . $this->db_hrms->database . ".jabatan_akademik.tunjangan as tunjangan_fungsional,
                        
                    " . $this->db_hrms->database . ".jabatan_struktural.nama_jabatan as j_struktural, 
                    " . $this->db_hrms->database . ".jabatan_struktural.tunjangan as tunjangan_struktural,
                        
                    `" . $this->db_akademik->database . "`.`ak_prodi`.`nama` as `nama_prodi`, 
                    `" . $this->db_akademik->database . "`.`ak_fakultas`.`nama` as `nama_fakultas`,

                    " . $this->db_hrms->database . ".golongan_pangkat.golongan, 
                    " . $this->db_hrms->database . ".golongan_pangkat.pangkat, 
                    " . $this->db_hrms->database . ".golongan_pangkat.id as golpang_id,

                    " . $this->db_hrms->database . ".gaji_generate.id as gaji_generate_id,
                    " . $this->db_hrms->database . ".gaji_generate.bulan,
                    " . $this->db_hrms->database . ".gaji_generate.status_payment"
            );

            if (!empty($filter)) {
                $this->db->where($filter);
            }

            $this->db->from($this->db_hrms->database . ".pegawai");

            $this->db->join($this->db_hrms->database . ".trans_jabatan_akademik",  $this->db_hrms->database . ".trans_jabatan_akademik.pegawai_id=pegawai.id AND " . $this->db_hrms->database . ".trans_jabatan_akademik.id = (SELECT MAX(" . $this->db_hrms->database . ".trans_jabatan_akademik.id) FROM " . $this->db_hrms->database . ".trans_jabatan_akademik WHERE " . $this->db_hrms->database . ".pegawai.id=" . $this->db_hrms->database . ".trans_jabatan_akademik.pegawai_id)", 'LEFT OUTER');
            $this->db->join($this->db_hrms->database . ".jabatan_akademik",  $this->db_hrms->database . ".jabatan_akademik.id=" . $this->db_hrms->database . ".trans_jabatan_akademik.akademik_id", "LEFT");

            $this->db->join($this->db_hrms->database . ".trans_jabatan_struktural",  $this->db_hrms->database . ".trans_jabatan_struktural.pegawai_id=pegawai.id AND " . $this->db_hrms->database . ".trans_jabatan_struktural.id = (SELECT MAX(" . $this->db_hrms->database . ".trans_jabatan_struktural.id) FROM " . $this->db_hrms->database . ".trans_jabatan_struktural WHERE " . $this->db_hrms->database . ".pegawai.id=" . $this->db_hrms->database . ".trans_jabatan_struktural.pegawai_id)", 'LEFT OUTER');
            $this->db->join($this->db_hrms->database . ".jabatan_struktural",  $this->db_hrms->database . ".jabatan_struktural.id=" . $this->db_hrms->database . ".trans_jabatan_struktural.struktural_id", "LEFT");

            $this->db->join($this->db_akademik->database . ".ak_prodi", $this->db_akademik->database . ".ak_prodi.id_prodi = " . $this->db_hrms->database . ".pegawai.homebase", "LEFT");
            $this->db->join($this->db_akademik->database . ".ak_fakultas", $this->db_akademik->database . ".ak_fakultas.id_fakultas = " . $this->db_akademik->database . ".ak_prodi.id_fakultas", "LEFT");

            $this->db->join($this->db_hrms->database . ".golongan_pangkat", $this->db_hrms->database . ".golongan_pangkat.id = " . $this->db_hrms->database . ".pegawai.golongan_dan_pangkat");
            $this->db->join($this->db_hrms->database . ".gaji_generate", $this->db_hrms->database . ".gaji_generate.pegawai_id = " . $this->db_hrms->database . ".pegawai.id");
            $query = $this->db->get()->result_array();
            return $query;
        }
    }

    public function data_gaji($filter = [])
    {
        if (array_key_exists($this->db_hrms->database . ".gaji_rapel.bulan", $filter) || array_key_exists($this->db_hrms->database . ".bulan", $filter)) {
            $this->db->select(
                $this->db_hrms->database . ".pegawai.id as peg_id, 
                " . $this->db_hrms->database . ".pegawai.nip, 
                " . $this->db_hrms->database . ".pegawai.nama_depan, 
                " . $this->db_hrms->database . ".pegawai.nama_tengah, 
                " . $this->db_hrms->database . ".pegawai.nama_belakang,
                " . $this->db_hrms->database . ".pegawai.gelar_depan, 
                " . $this->db_hrms->database . ".pegawai.gelar_belakang, 
                " . $this->db_hrms->database . ".pegawai.tmt, 
                " . $this->db_hrms->database . ".pegawai.status_kepegawaian, 
                " . $this->db_hrms->database . ".pegawai.nidn_nidk_nitk,
                 
                " . $this->db_hrms->database . ".gaji_rapel.id as gaji_generate_id, 
                " . $this->db_hrms->database . ".gaji_rapel.bulan, 
                " . $this->db_hrms->database . ".gaji_rapel.gaji_pokok, 
                " . $this->db_hrms->database . ".gaji_rapel.t_jabatan_akademik, 
                " . $this->db_hrms->database . ".gaji_rapel.t_jabatan_struktural,
                " . $this->db_hrms->database . ".gaji_rapel.t_absensi, 
                " . $this->db_hrms->database . ".gaji_rapel.t_lembur, 
                " . $this->db_hrms->database . ".gaji_rapel.t_insentif_sks_lebih, 
                " . $this->db_hrms->database . ".gaji_rapel.asuransi_kesehatan, 
                " . $this->db_hrms->database . ".gaji_rapel.asuransi_ketenagakerjaan, 
                " . $this->db_hrms->database . ".gaji_rapel.dana_pensiun, 
                " . $this->db_hrms->database . ".gaji_rapel.tunjangan_keluarga, 
                " . $this->db_hrms->database . ".gaji_rapel.take_home_pay, 
                " . $this->db_hrms->database . ".gaji_rapel.potongan,
                " . $this->db_hrms->database . ".gaji_rapel.total_remun,
                " . $this->db_hrms->database . ".gaji_rapel.status_payment,
                    
                " . $this->db_hrms->database . ".pegawai_rekening.bank,
                " . $this->db_hrms->database . ".pegawai_rekening.no_rekening"
            );

            if (!empty($filter)) {
                $this->db->where($filter);
            }

            $this->db->join($this->db_hrms->database . ".gaji_rapel", $this->db_hrms->database . ".gaji_rapel.pegawai_id = " . $this->db_hrms->database . ".pegawai.id");
            $this->db->join($this->db_hrms->database . ".pegawai_rekening", $this->db_hrms->database . ".pegawai_rekening.pegawai_id = " . $this->db_hrms->database . ".pegawai.id", "LEFT");

            $this->db->from($this->db_hrms->database . ".pegawai");

            $query = $this->db->get()->result_array();
            return $query;
        }
        return false;
    }

    public function gaji_generate($filter = [])
    {
        $this->db->select(
            $this->db_hrms->database . ".pegawai.id as peg_id, 
                " . $this->db_hrms->database . ".pegawai.nip, 
                " . $this->db_hrms->database . ".pegawai.nama_depan, 
                " . $this->db_hrms->database . ".pegawai.nama_tengah, 
                " . $this->db_hrms->database . ".pegawai.nama_belakang,
                " . $this->db_hrms->database . ".pegawai.gelar_depan, 
                " . $this->db_hrms->database . ".pegawai.gelar_belakang, 
                " . $this->db_hrms->database . ".pegawai.tmt, 
                " . $this->db_hrms->database . ".pegawai.nidn_nidk_nitk,
                " . $this->db_hrms->database . ".pegawai.kat_pegawai,
                    
                " . $this->db_hrms->database . ".ref_status_kepegawaian.id as id_status_kepegawaian, 
                " . $this->db_hrms->database . ".ref_status_kepegawaian.nama as status_kepegawaian,
                    
                " . $this->db_hrms->database . ".jabatan_struktural.nama_jabatan as j_struktural, 
                " . $this->db_hrms->database . ".jabatan_struktural.tunjangan as tunjangan_struktural,
                " . $this->db_hrms->database . ".trans_jabatan_struktural.is_paid,
                " . $this->db_hrms->database . ".gaji_nominal_person.nominal_gaji"
        );

        if (!empty($filter)) {
            $this->db->where($filter);
        }
        $this->db->from($this->db_hrms->database . ".pegawai");

        $this->db->join($this->db_hrms->database . ".ref_status_kepegawaian", $this->db_hrms->database . ".ref_status_kepegawaian.id = " . $this->db_hrms->database . ".pegawai.status_kepegawaian");

        $this->db->join($this->db_hrms->database . ".trans_jabatan_struktural",  $this->db_hrms->database . ".trans_jabatan_struktural.pegawai_id=pegawai.id AND " . $this->db_hrms->database . ".trans_jabatan_struktural.id = (SELECT MAX(" . $this->db_hrms->database . ".trans_jabatan_struktural.id) FROM " . $this->db_hrms->database . ".trans_jabatan_struktural WHERE " . $this->db_hrms->database . ".pegawai.id=" . $this->db_hrms->database . ".trans_jabatan_struktural.pegawai_id)", 'LEFT OUTER');
        $this->db->join($this->db_hrms->database . ".jabatan_struktural",  $this->db_hrms->database . ".jabatan_struktural.id=" . $this->db_hrms->database . ".trans_jabatan_struktural.struktural_id", "LEFT");

        $this->db->join($this->db_hrms->database . ".gaji_nominal_person", $this->db_hrms->database . ".gaji_nominal_person.pegawai_id = " . $this->db_hrms->database . ".pegawai.id", "LEFT");

        $query = $this->db->get()->result_array();
        return $query;
    }

    public function data_kehadiran_single($pegawai_id, $bulan_id)
    {
        $this->db->select("
            " . $this->db_hrms->database . ".presensi.id as presensi_id,
            " . $this->db_hrms->database . ".presensi.tahun_bulan, 
            " . $this->db_hrms->database . ".presensi.jumlah_masuk, 
            " . $this->db_hrms->database . ".presensi.nominal_harian, 
            " . $this->db_hrms->database . ".presensi.total,  

            " . $this->db_hrms->database . ".pegawai.id as peg_id, 
            " . $this->db_hrms->database . ".pegawai.nama_depan, 
            " . $this->db_hrms->database . ".pegawai.nama_tengah, 
            " . $this->db_hrms->database . ".pegawai.nama_belakang,
        ");
        $this->db->join($this->db_hrms->database . ".pegawai", $this->db_hrms->database . ".pegawai.id = " . $this->db_hrms->database . ".presensi.pegawai_id");
        $this->db->from($this->db_hrms->database . ".presensi");
        $this->db->where($this->db_hrms->database . ".presensi.pegawai_id", $pegawai_id);
        $this->db->where($this->db_hrms->database . ".presensi.tahun_bulan", $bulan_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function data_lembur_single($pegawai_id, $bulan_id)
    {
        $this->db->select("
            " . $this->db_hrms->database . ".lembur.id as lembur_id, 
            " . $this->db_hrms->database . ".lembur.bulan, 
            " . $this->db_hrms->database . ".lembur.jam_lembur, 
            " . $this->db_hrms->database . ".lembur.nominal_per_jam, 
            " . $this->db_hrms->database . ".lembur.total_nilai, 
            " . $this->db_hrms->database . ".lembur.nilai_bulk,

            " . $this->db_hrms->database . ".pegawai.id as peg_id, 
            " . $this->db_hrms->database . ".pegawai.nama_depan, 
            " . $this->db_hrms->database . ".pegawai.nama_tengah, 
            " . $this->db_hrms->database . ".pegawai.nama_belakang,
        ");
        $this->db->join($this->db_hrms->database . ".pegawai", $this->db_hrms->database . ".pegawai.id = " . $this->db_hrms->database . ".lembur.pegawai_id");
        $this->db->from($this->db_hrms->database . ".lembur");
        $this->db->where($this->db_hrms->database . ".lembur.pegawai_id", $pegawai_id);
        $this->db->where($this->db_hrms->database . ".lembur.bulan", $bulan_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function data_potongan_single($pegawai_id, $bulan_id)
    {
        $this->db->select_sum($this->db_hrms->database . ".gaji_potongan_ref.nominal");
        $this->db->select("
            " . $this->db_hrms->database . ".pegawai.id as peg_id, 
            " . $this->db_hrms->database . ".pegawai.nama_depan, 
            " . $this->db_hrms->database . ".pegawai.nama_tengah, 
            " . $this->db_hrms->database . ".pegawai.nama_belakang,
        ");
        $this->db->join($this->db_hrms->database . ".gaji_potongan_ref", $this->db_hrms->database . ".gaji_potongan_ref.id = " . $this->db_hrms->database . ".gaji_potongan_trans.potongan_ref_id");
        $this->db->join($this->db_hrms->database . ".pegawai", $this->db_hrms->database . ".pegawai.id = " . $this->db_hrms->database . ".gaji_potongan_trans.pegawai_id");
        $this->db->from($this->db_hrms->database . ".gaji_potongan_trans");
        $this->db->where($this->db_hrms->database . ".pegawai.id", $pegawai_id);
        $this->db->where($this->db_hrms->database . ".gaji_potongan_trans.bulan", $bulan_id);
        $this->db->where($this->db_hrms->database . ".gaji_potongan_ref.deleted_at", NULL);
        $query = $this->db->get();
        return $query->row();
    }

    public function penghasilan_dosen_cetak($bulan, $pegawai_id)
    {
        $sql = "
            SELECT 
                " . $this->db_hrms->database . ".pegawai.id as peg_id, 
                " . $this->db_hrms->database . ".pegawai.nip, 
                " . $this->db_hrms->database . ".pegawai.nama_depan, 
                " . $this->db_hrms->database . ".pegawai.nama_tengah, 
                " . $this->db_hrms->database . ".pegawai.nama_belakang,
                " . $this->db_hrms->database . ".pegawai.gelar_depan, 
                " . $this->db_hrms->database . ".pegawai.gelar_belakang, 
                " . $this->db_hrms->database . ".pegawai.tmt, 
                " . $this->db_hrms->database . ".pegawai.status_kepegawaian, 
                " . $this->db_hrms->database . ".pegawai.nidn_nidk_nitk,
                
                " . $this->db_hrms->database . ".ref_status_kepegawaian.nama as status_kepegawaian_nama,
                
                " . $this->db_hrms->database . ".golongan_pangkat.golongan, 
                " . $this->db_hrms->database . ".golongan_pangkat.pangkat, 
                " . $this->db_hrms->database . ".golongan_pangkat.id as golpang_id,

                " . $this->db_hrms->database . ".gaji_nominal_person.id as gaji_nominal_person_id, 
                " . $this->db_hrms->database . ".gaji_nominal_person.nominal_gaji,

                " . $this->db_hrms->database . ".gaji_generate.bulan, 
                " . $this->db_hrms->database . ".gaji_generate.gaji_pokok, 
                " . $this->db_hrms->database . ".gaji_generate.t_jabatan_akademik, 
                " . $this->db_hrms->database . ".gaji_generate.t_jabatan_struktural,
                " . $this->db_hrms->database . ".gaji_generate.t_absensi, 
                " . $this->db_hrms->database . ".gaji_generate.t_lembur, 
                " . $this->db_hrms->database . ".gaji_generate.t_insentif_sks_lebih, 
                " . $this->db_hrms->database . ".gaji_generate.take_home_pay,

                " . $this->db_hrms->database . ".jabatan_akademik.nama_jabatan, 
                " . $this->db_hrms->database . ".jabatan_akademik.angka_kredit, 
                " . $this->db_hrms->database . ".jabatan_akademik.tunjangan as tunjangan_fungsional,
                
                " . $this->db_hrms->database . ".jabatan_struktural.nama_jabatan as j_struktural, 
                " . $this->db_hrms->database . ".jabatan_struktural.tunjangan as tunjangan_struktural

            FROM " . $this->db_hrms->database . ".pegawai
            
            JOIN " . $this->db_hrms->database . ".ref_status_kepegawaian ON " . $this->db_hrms->database . ".ref_status_kepegawaian.id = " . $this->db_hrms->database . ".pegawai.status_kepegawaian
            JOIN " . $this->db_hrms->database . ".golongan_pangkat ON " . $this->db_hrms->database . ".golongan_pangkat.id = " . $this->db_hrms->database . ".pegawai.golongan_dan_pangkat
            LEFT JOIN " . $this->db_hrms->database . ".gaji_nominal_person ON " . $this->db_hrms->database . ".gaji_nominal_person.pegawai_id = " . $this->db_hrms->database . ".pegawai.id
            JOIN " . $this->db_hrms->database . ".gaji_generate ON " . $this->db_hrms->database . ".gaji_generate.pegawai_id = " . $this->db_hrms->database . ".pegawai.id
    
            LEFT OUTER JOIN " . $this->db_hrms->database . ".trans_jabatan_akademik ON " . $this->db_hrms->database . ".trans_jabatan_akademik.pegawai_id=" . $this->db_hrms->database . ".pegawai.id
            AND " . $this->db_hrms->database . ".trans_jabatan_akademik.id = (SELECT MAX(" . $this->db_hrms->database . ".trans_jabatan_akademik.id) FROM " . $this->db_hrms->database . ".trans_jabatan_akademik
                                            WHERE " . $this->db_hrms->database . ".pegawai.id=" . $this->db_hrms->database . ".trans_jabatan_akademik.pegawai_id)    
            LEFT OUTER JOIN " . $this->db_hrms->database . ".jabatan_akademik ON " . $this->db_hrms->database . ".jabatan_akademik.id=" . $this->db_hrms->database . ".trans_jabatan_akademik.akademik_id 

            LEFT OUTER JOIN " . $this->db_hrms->database . ".trans_jabatan_struktural ON " . $this->db_hrms->database . ".trans_jabatan_struktural.pegawai_id = " . $this->db_hrms->database . ".pegawai.id
            AND " . $this->db_hrms->database . ".trans_jabatan_struktural.id = (SELECT MAX(" . $this->db_hrms->database . ".trans_jabatan_struktural.id) FROM " . $this->db_hrms->database . ".trans_jabatan_struktural
                                            WHERE " . $this->db_hrms->database . ".pegawai.id=" . $this->db_hrms->database . ".trans_jabatan_struktural.pegawai_id) 
            LEFT OUTER JOIN " . $this->db_hrms->database . ".jabatan_struktural ON " . $this->db_hrms->database . ".jabatan_struktural.id=" . $this->db_hrms->database . ".trans_jabatan_struktural.struktural_id

            WHERE  " . $this->db_hrms->database . ".pegawai.id = $pegawai_id
                    AND " . $this->db_hrms->database . ".gaji_generate.bulan =  $bulan  
        ";
        $query =  $this->db->query($sql);
        return $query->row();
    }

    public function slip_gaji_data($bulan, $pegawai_id)
    {
        $sql = "
                SELECT 
                    " . $this->db_hrms->database . ".pegawai.id as peg_id, 
                    " . $this->db_hrms->database . ".pegawai.nip, 
                    " . $this->db_hrms->database . ".pegawai.nama_depan, 
                    " . $this->db_hrms->database . ".pegawai.nama_tengah, 
                    " . $this->db_hrms->database . ".pegawai.nama_belakang,
                    " . $this->db_hrms->database . ".pegawai.gelar_depan, 
                    " . $this->db_hrms->database . ".pegawai.gelar_belakang, 
                    " . $this->db_hrms->database . ".pegawai.tmt, 
                    " . $this->db_hrms->database . ".pegawai.status_kepegawaian, 
                    " . $this->db_hrms->database . ".pegawai.nidn_nidk_nitk,

                    " . $this->db_hrms->database . ".ref_status_kepegawaian.nama as status_kepegawaian_nama,

                    " . $this->db_hrms->database . ".gaji_nominal_person.nominal_gaji,

                    " . $this->db_hrms->database . ".gaji_generate.t_jabatan_struktural as gaji_generate_t_jabatan_struktural,

                    " . $this->db_hrms->database . ".trans_jabatan_akademik.id, 
                    " . $this->db_hrms->database . ".trans_jabatan_akademik.pegawai_id, 
                    " . $this->db_hrms->database . ".trans_jabatan_akademik.akademik_id,
                    
                    " . $this->db_hrms->database . ".jabatan_akademik.nama_jabatan, 
                    " . $this->db_hrms->database . ".jabatan_akademik.angka_kredit, 
                    " . $this->db_hrms->database . ".jabatan_akademik.tunjangan as tunjangan_fungsional,
                    
                    " . $this->db_hrms->database . ".jabatan_struktural.nama_jabatan as j_struktural, 
                    " . $this->db_hrms->database . ".jabatan_struktural.tunjangan as tunjangan_struktural,
                    
                    `" . $this->db_akademik->database . "`.`ak_prodi`.`nama` as `nama_prodi`, 
                    `" . $this->db_akademik->database . "`.`ak_fakultas`.`nama` as `nama_fakultas`,

                    `" . $this->db_hrms->database . "`.`divisi`.`nama` as `nama_divisi`,

                    " . $this->db_hrms->database . ".golongan_pangkat.golongan, " . $this->db_hrms->database . ".golongan_pangkat.pangkat, golongan_pangkat.id as golpang_id
                
                FROM " . $this->db_hrms->database . ".pegawai

                JOIN " . $this->db_hrms->database . ".ref_status_kepegawaian ON " . $this->db_hrms->database . ".ref_status_kepegawaian.id = " . $this->db_hrms->database . ".pegawai.status_kepegawaian
                
                LEFT JOIN " . $this->db_hrms->database . ".gaji_nominal_person ON " . $this->db_hrms->database . ".gaji_nominal_person.pegawai_id = " . $this->db_hrms->database . ".pegawai.id

                JOIN " . $this->db_hrms->database . ".gaji_generate ON " . $this->db_hrms->database . ".gaji_generate.pegawai_id = " . $this->db_hrms->database . ".pegawai.id 
                    AND " . $this->db_hrms->database . ".gaji_generate.bulan = " . $bulan . "
                    
                LEFT OUTER JOIN " . $this->db_hrms->database . ".trans_jabatan_akademik ON " . $this->db_hrms->database . ".trans_jabatan_akademik.pegawai_id=" . $this->db_hrms->database . ".pegawai.id
                AND " . $this->db_hrms->database . ".trans_jabatan_akademik.id = (SELECT MAX(" . $this->db_hrms->database . ".trans_jabatan_akademik.id) FROM " . $this->db_hrms->database . ".trans_jabatan_akademik
                                                WHERE " . $this->db_hrms->database . ".pegawai.id=" . $this->db_hrms->database . ".trans_jabatan_akademik.pegawai_id)    
                LEFT OUTER JOIN " . $this->db_hrms->database . ".jabatan_akademik ON " . $this->db_hrms->database . ".jabatan_akademik.id=" . $this->db_hrms->database . ".trans_jabatan_akademik.akademik_id 

                LEFT OUTER JOIN " . $this->db_hrms->database . ".trans_jabatan_struktural ON " . $this->db_hrms->database . ".trans_jabatan_struktural.pegawai_id = " . $this->db_hrms->database . ".pegawai.id
                AND " . $this->db_hrms->database . ".trans_jabatan_struktural.id = (SELECT MAX(" . $this->db_hrms->database . ".trans_jabatan_struktural.id) FROM " . $this->db_hrms->database . ".trans_jabatan_struktural
                                                WHERE " . $this->db_hrms->database . ".pegawai.id=" . $this->db_hrms->database . ".trans_jabatan_struktural.pegawai_id) 
                LEFT OUTER JOIN " . $this->db_hrms->database . ".jabatan_struktural ON " . $this->db_hrms->database . ".jabatan_struktural.id=" . $this->db_hrms->database . ".trans_jabatan_struktural.struktural_id 
                
                LEFT JOIN `" . $this->db_akademik->database . "`.`ak_prodi` ON `" . $this->db_akademik->database . "`.`ak_prodi`.`id_prodi` = `" . $this->db_hrms->database . "`.`pegawai`.`homebase`
                LEFT JOIN `" . $this->db_akademik->database . "`.`ak_fakultas` ON `" . $this->db_akademik->database . "`.`ak_fakultas`.`id_fakultas` = `" . $this->db_akademik->database . "`.`ak_prodi`.`id_fakultas`
                
                LEFT JOIN `" . $this->db_hrms->database . "`.`divisi` ON `" . $this->db_hrms->database . "`.`divisi`.`id` = `" . $this->db_hrms->database . "`.`pegawai`.`homebase`

                JOIN " . $this->db_hrms->database . ".golongan_pangkat ON " . $this->db_hrms->database . ".golongan_pangkat.id = " . $this->db_hrms->database . ".pegawai.golongan_dan_pangkat
                WHERE " . $this->db_hrms->database . ".pegawai.id = " . $pegawai_id . "
            ";
        $query =  $this->db->query($sql);
        return $query->row();
    }
}
