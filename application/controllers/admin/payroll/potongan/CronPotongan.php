<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CronPotongan extends REST_Controller
{
    public $db_hrms;

    function __construct()
    {
        parent::__construct();

        $this->db_hrms = $this->load->database('hrms', TRUE);

        $this->load->model('payroll/M_potongan');
    }

    // Function API untuk trigger potongan perbulan
    function auth()
    {
        //password: hvBa{x/u>$U.^^
        $auth = [
            'username' => 'cron-potongan',
            'password' => '$2a$12$9mgANKSJCsiajK0OK6Rv8uXUyVdhua59CEbqpFhZLKeiiNyrvEam6'
        ];
        $exist = $this->getPost('username') == $auth['username'] ? true : false;
        if ($exist) {
            if (password_verify($this->getPost('password'), $auth['password'])) {
                return true;
            } else {
                return $this->response(['success' => false, 'message' => 'User not found']);
            }
        } else {
            return $this->response(['success' => false, 'message' => 'User not found']);
        }
    }

    public function api_cron_potongan()
    {
        if ($this->auth()) {
            $data_potongan_active = $this->db_hrms->get_where('gaji_potongan_aktif', ['is_active' => 1])->result_array();

            $data = [];
            $counter = (int) 0;
            foreach ($data_potongan_active as $row) {
                $check_data_potongan_trans = $this->db_hrms->get_where('gaji_potongan_trans', [
                    'pegawai_id' => $row['pegawai_id'],
                    'potongan_ref_id' => $row['potongan_ref_id'],
                    'bulan' => date('Ym'),
                ])->row();
                if (empty($check_data_potongan_trans)) {
                    $insert = $this->db_hrms->insert('gaji_potongan_trans', [
                        'pegawai_id' => $row['pegawai_id'],
                        'bulan' => date('Ym'),
                        'potongan_ref_id' => $row['potongan_ref_id'],
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                    $counter++;
                }
            }

            if ($counter > 0) {
                $this->response(['success' => true, 'data' => 'updated ' . $counter . ' data']);
            } else {
                $this->response(['success' => true, 'data' => 'no data updated']);
            }
        }
    }

    // Function biasa untuk trigger potongan perbulan
    public function cron_potongan(string $key = NULL)
    {
        // key : cfh7MIUnIX
        $hashed_key = '$2a$12$sxY66blnD0wPFSvZ2Xfse.FFME7kEETVygM4Y45YK3CT25SoG2sGq';
        if (!empty($key)) {
            if (password_verify($key, $hashed_key)) {
                $data_potongan_active = $this->db_hrms->get_where('gaji_potongan_aktif', ['is_active' => 1])->result_array();

                $data = [];
                $counter = (int) 0;
                foreach ($data_potongan_active as $row) {
                    $check_data_potongan_trans = $this->db_hrms->get_where('gaji_potongan_trans', [
                        'pegawai_id' => $row['pegawai_id'],
                        'potongan_ref_id' => $row['potongan_ref_id'],
                        'bulan' => date('Ym'),
                    ])->row();
                    if (empty($check_data_potongan_trans)) {
                        $insert = $this->db_hrms->insert('gaji_potongan_trans', [
                            'pegawai_id' => $row['pegawai_id'],
                            'bulan' => date('Ym'),
                            'potongan_ref_id' => $row['potongan_ref_id'],
                            'created_at' => date('Y-m-d H:i:s'),
                        ]);
                        $counter++;
                    }
                }

                if ($counter > 0) {;
                    $response = (['status' => 200, 'message' => 'updated ' . $counter . ' data']);
                    echo json_encode($response);
                } else {
                    $response = (['status' => 200, 'message' => 'No data updated']);
                    echo json_encode($response);
                }
            } else {
                $response = (['status' => 404, 'message' => 'Token mismatch']);
                echo json_encode($response);
            }
        } else {
            $response = (['status' => 404, 'message' => 'Please provide token']);
            echo json_encode($response);
        }
    }
}
