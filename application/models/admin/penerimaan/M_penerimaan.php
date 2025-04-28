<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_penerimaan extends CI_Model
{
    private $db_keuangan;

    function __construct()
    {
        parent::__construct();

        $this->db_keuangan = $this->load->database('keuangan_payment', TRUE);
    }

    public function get_db($table, $data = NULL, $type = 'row')
    {
        if ($data === NULL) return $this->db->get($table)->result_array();
        elseif ($type === 'row') return $this->db->get_where($table, $data)->row_array();
        elseif ($type === 'result') return $this->db->get_where($table, $data)->result_array();
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

    public function get_prodi_order_by_fakultas()
    {
        $this->db->order_by('id_fakultas', 'desc');
        $query = $this->db->get('ak_prodi');

        return $query->result_array();
    }

    public function get_ukt()
    {
        $this->db_keuangan->select('NOCUST, NMCUST, PRODI');
        $this->db_keuangan->select_sum('BILLAM');
        $this->db_keuangan->select_sum('PAIDAM');
        $this->db_keuangan->from('tb_tagihan');
        $this->db_keuangan->where('ENABLED', 1);
        $this->db_keuangan->group_by('id_cust');
        $query = $this->db_keuangan->get();

        return $query->result_array();
    }

    public function get_ukt_mahasiswa($nim)
    {
        $id_cust = $this->db_keuangan->get_where('tb_tagihan', ['NOCUST' => $nim])->row_array();

        $this->db_keuangan->select('KODE_AKUN, NMCUST, SEMESTER, BILLNM, BILLAM, PAIDAM, PAIDST, PAIDDT, PAIDBY');
        $this->db_keuangan->from('tb_tagihan');
        $this->db_keuangan->where([
            'id_cust' => $id_cust['id_cust'],
            'ENABLED' => 1
        ]);
        $query = $this->db_keuangan->get();

        return $query->result_array();
    }

    public function get_total_per_pos()
    {
        $this->db_keuangan->select('td.POS_TAGIHAN, td.NAMA_POS');
        $this->db_keuangan->select_sum('t.BILLAM');
        $this->db_keuangan->from('tb_tagihan t');
        $this->db_keuangan->join('tb_tagihan_detail td', 't.id_bill = td.id_bill');
        $this->db_keuangan->where('t.ENABLED', 1);
        $this->db_keuangan->group_by('td.POS_TAGIHAN');
        $query = $this->db_keuangan->get();

        return $query->result_array();
    }

    public function get_rincian_per_pos($pos)
    {
        $this->db_keuangan->select('t.NOCUST, t.NMCUST, t.PRODI');
        $this->db_keuangan->select_sum('t.BILLAM');
        $this->db_keuangan->select_sum('t.PAIDAM');
        $this->db_keuangan->from('tb_tagihan t');
        $this->db_keuangan->join('tb_tagihan_detail td', 't.id_bill = td.id_bill');
        $this->db_keuangan->where([
            'td.POS_TAGIHAN' => $pos,
            't.ENABLED' => 1
        ]);
        $this->db_keuangan->group_by('t.id_cust');
        $query = $this->db_keuangan->get();

        return $query->result_array();
    }
}
