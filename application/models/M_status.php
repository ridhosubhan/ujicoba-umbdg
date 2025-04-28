<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_status extends CI_Model
{
    public function get_status()
    {
        $tahun = $this->db->get_where('ak_tahun', ['status' => 'Y'])->row_array();

        return $this->db
            ->select(
                'j.*, j.kelas as kelas_matkul, m.kode_matkul,
                m.nama as nama_matkul, p.nama as nama_prodi, p.*'
            )
            ->from('ak_jadwal j')
            ->join('hrms_umb.pegawai p', 'j.nik_dosen = p.id')
            ->join('ak_matkul m', 'j.id_matkul = m.id_matkul')
            ->join('ak_prodi p', 'm.id_prodi = p.id_prodi')
            ->where('j.id_tahun', $tahun['id_tahun'])
            ->get()->result_array();
    }

    public function get_mahasiswa($nim = '')
    {
        if ($nim !== '') {
            return $this->db
                ->select(
                    'm.nim, m.nama as nama_mahasiswa,
                    p.nama as nama_prodi, m.tahun_angkatan,
                    m.krs, m.uts, m.uas'
                )
                ->from('ak_mahasiswa m')
                ->join('ak_prodi p', 'm.id_prodi = p.id_prodi')
                ->where('m.nim', $nim);
        } else {
            return $this->db
                ->select(
                    'm.nim, m.nama as nama_mahasiswa,
                p.nama as nama_prodi, m.tahun_angkatan,
                m.krs, m.uts, m.uas'
                )
                ->from('ak_mahasiswa m')
                ->join('ak_prodi p', 'm.id_prodi = p.id_prodi');
        }
    }

    public function get_list_mahasiswa($id_jadwal)
    {
        return $this->db
            ->select(
                'm.nim, m.nama as nama_mahasiswa,
                p.nama as nama_prodi, m.tahun_angkatan,
                m.krs, m.uts, m.uas'
            )
            ->from('ak_jadwal j')
            ->join('ak_krs k', 'j.id_jadwal = k.id_jadwal')
            ->join('ak_mahasiswa m', 'k.nim = m.nim')
            ->join('ak_prodi p', 'm.id_prodi = p.id_prodi')
            ->where(['j.id_jadwal' => $id_jadwal, 'm.status' => 'A']);
    }

    public function get_jadwal($id_jadwal)
    {
        return $this->db
            ->select('*')
            ->from('ak_jadwal j')
            ->join('ak_matkul m', 'j.id_matkul = m.id_matkul')
            ->where('j.id_jadwal', $id_jadwal)
            ->get()->row_array();
    }
}
