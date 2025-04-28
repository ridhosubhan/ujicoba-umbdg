<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PotonganList extends CI_Controller
{
    public $db_hrms;

    function __construct()
    {
        parent::__construct();

        $this->db_hrms = $this->load->database('hrms', TRUE);

        if (($this->session->userdata('logged') != TRUE)
            || ($this->session->userdata('access') != 'payroll_staff')
        ) {
            $url = base_url('login');
            redirect($url);
        };

        $this->load->model('payroll/M_potongan');
    }

    public function index()
    {
        if (!empty(@$this->input->get('potongan_rutin')) && @$this->input->get('potongan_rutin') == "Ya") {
            $filter = [
                'gaji_potongan_ref.id' => @$this->input->get('jenis_potongan'),
                'gaji_potongan_trans.bulan' => @$this->input->get('bulan'),
                'gaji_potongan_aktif.is_active' => 1
            ];
        } else if (!empty(@$this->input->get('potongan_rutin')) && @$this->input->get('potongan_rutin') == "Tidak") {
            $filter = [
                'gaji_potongan_ref.id' => @$this->input->get('jenis_potongan'),
                'gaji_potongan_trans.bulan' => @$this->input->get('bulan'),
                'gaji_potongan_aktif.is_active IS NULL' => NULL
            ];
        } else {
            $filter = [
                'gaji_potongan_ref.id' => @$this->input->get('jenis_potongan'),
                'gaji_potongan_trans.bulan' => @$this->input->get('bulan')
            ];
        }


        $data = [
            'title' => "Data Potongan Pegawai",
            'ref_potongan' => $this->db_hrms->order_by('created_at', 'DESC')->get('gaji_potongan_ref')->result_array(),
            'potongan_pegawai' => $this->M_potongan->get_list_potongan($filter),
            'tahun_gajian' => $this->db->distinct($this->db_hrms->database . ".gaji_generate.bulan")
                ->select(
                    $this->db_hrms->database . ".gaji_generate.bulan as bulan
                "
                )
                ->from($this->db_hrms->database . ".gaji_generate")
                ->not_like($this->db_hrms->database . ".gaji_generate.bulan", date('Y') . date('m'))
                ->order_by($this->db_hrms->database . ".gaji_generate.bulan", "desc")
                ->get()
                ->result_array(),
        ];
        $this->load->view('payroll/potongan/list/index', $data);
    }

    public function sinkron_potongan()
    {
        $this->form_validation->set_rules('bulan_sync', 'Bulan', 'required', array('required' => 'Wajib mengisi %s'));
        if ($this->form_validation->run() == FALSE) {
            $error_message = array(
                'bulan_sync' => form_error('bulan_sync'),
            );
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array(
                    'status' => 0,
                    'error_message' => $error_message
                )));
        } else {
            $data_potongan_active = $this->db_hrms->get_where('gaji_potongan_aktif', ['is_active' => 1])->result_array();

            $data = [];
            $counter = (int) 0;
            foreach ($data_potongan_active as $row) {
                $check_data_potongan_trans = $this->db_hrms->get_where('gaji_potongan_trans', [
                    'pegawai_id' => $row['pegawai_id'],
                    'potongan_ref_id' => $row['potongan_ref_id'],
                    'bulan' => $this->input->post('bulan_sync'),
                ])->row();
                if (empty($check_data_potongan_trans)) {
                    $insert = $this->db_hrms->insert('gaji_potongan_trans', [
                        'pegawai_id' => $row['pegawai_id'],
                        'bulan' => $this->input->post('bulan_sync'),
                        'potongan_ref_id' => $row['potongan_ref_id'],
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                    $counter++;
                }
            }

            if ($counter > 0) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array(
                        'type' => 1,
                        'message' => 'Updated ' . $counter . ' data',
                    )));
            } else {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array(
                        'type' => 1,
                        'message' => 'No data updated',
                    )));
            }
        }
    }
}
