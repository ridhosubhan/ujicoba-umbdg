<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_administrator extends CI_Model
{
    public function get_db($table, $data = null, $type = 'row')
    {
        if ($data === null) return $this->db->get($table)->result_array();
        elseif ($type === 'row') return $this->db->get_where($table, $data)->row_array();
        elseif ($type === 'result') return $this->db->get_where($table, $data)->result_array();
    }

    public function get_db_keuangan_anggaran($table, $data = null, $type = 'row')
    {
        $keuangan = $this->load->database('keuangan_anggaran', TRUE);

        if ($data === null) return $keuangan->get($table)->result_array();
        elseif ($type === 'row') return $keuangan->get_where($table, $data)->row_array();
        elseif ($type === 'result') return $keuangan->get_where($table, $data)->result_array();
    }

    public function get_db_keuangan_payment($table, $data = null, $type = 'row')
    {
        $keuangan = $this->load->database('keuangan_payment', TRUE);

        if ($data === null) return $keuangan->get($table)->result_array();
        elseif ($type === 'row') return $keuangan->get_where($table, $data)->row_array();
        elseif ($type === 'result') return $keuangan->get_where($table, $data)->result_array();
    }

    public function get_db_keuangan_sias($table, $data = null, $type = 'row')
    {
        $keuangan = $this->load->database('keuangan_sias', TRUE);

        if ($data === null) return $keuangan->get($table)->result_array();
        elseif ($type === 'row') return $keuangan->get_where($table, $data)->row_array();
        elseif ($type === 'result') return $keuangan->get_where($table, $data)->result_array();
    }

    public function get_db_count($table, $data)
    {
        if ($data === NULL) $this->db->from($table);
        else {
            $this->db->from($table);
            $this->db->where($data);
        }

        return $this->db->count_all_results();
    }

    public function jumlah_history_status($id_prodi, $type, $status, $tahun)
    {
        $this->db->from('ak_mahasiswa m');
        $this->db->join('ak_history_status h', 'h.nim = m.nim');
        $this->db->where(['m.id_prodi' => $id_prodi, "h.$type" => $status, 'h.id_tahun' => $tahun]);

        return $this->db->count_all_results();
    }

    public function aktifator($type, $nim, $tahun)
    {
        $tahun_aktif = $this->db->get_where('ak_tahun', ['status' => 'Y'])->row_array();

        if ($tahun === $tahun_aktif['id_tahun']) {
            $status = $this->db->get_where('ak_mahasiswa', ['nim' => $nim])->row_array();

            if ($status[$type] == 'Y') {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Portal ' . strtoupper($type) . ' Mahasiswa Berhasil Diblokir!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                return $this->db->update('ak_mahasiswa', [$type => 'N', 'status' => 'N'], ['nim' => $nim]);
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Portal ' . strtoupper($type) . ' Mahasiswa Berhasil Dibuka!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                return $this->db->update('ak_mahasiswa', [$type => 'Y', 'status' => 'A'], ['nim' => $nim]);
            }
        } else {
            $status = $this->db->get_where('ak_history_status', ['nim' => $nim, 'id_tahun' => $tahun])->row_array();

            if ($status[$type] == 'Y') {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Portal ' . strtoupper($type) . ' Mahasiswa Berhasil Diblokir!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                return $this->db->update('ak_history_status', [$type => 'N'], ['nim' => $nim, 'id_tahun' => $tahun]);
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Portal ' . strtoupper($type) . ' Mahasiswa Berhasil Dibuka!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                return $this->db->update('ak_history_status', [$type => 'Y'], ['nim' => $nim, 'id_tahun' => $tahun]);
            }
        }
    }
}
