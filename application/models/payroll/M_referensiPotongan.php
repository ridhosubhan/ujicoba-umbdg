<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_referensiPotongan extends CI_Model
{
    public $db_hrms;

    public function __construct()
    {
        parent::__construct();

        $this->db_hrms = $this->load->database('hrms', TRUE);
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
}
