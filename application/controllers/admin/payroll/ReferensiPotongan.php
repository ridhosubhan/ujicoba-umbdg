<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReferensiPotongan extends CI_Controller
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

        $this->load->model('payroll/M_referensiPotongan');
    }

    public function index()
    {
        $data = [
            'title' => "Referensi Potongan",
            'potongan' => $this->db_hrms->from('gaji_potongan_ref')->where('deleted_at', NULL)->order_by('created_at', 'DESC')->get()->result_array()
        ];
        $this->load->view('payroll/potongan/referensi_potongan', $data);
    }

    public function store()
    {
        $this->form_validation->set_rules('nama_potongan', 'Nama Potongan', 'required', array(
            'required' => '%s wajib diisi.',
        ));
        $this->form_validation->set_rules('nominal_potongan', 'Nominal Potongan', 'required|numeric', array(
            'required' => '%s wajib diisi.',
            'numeric' => 'diisi angka.',
        ));
        if ($this->form_validation->run() == FALSE) {
            $error_message = array(
                'nama_potongan' => form_error('nama_potongan'),
                'nominal_potongan' => form_error('nominal_potongan'),
            );
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array(
                    'status' => 0,
                    'error_message' => $error_message
                )));
        } else {
            $data = [
                'nama' => $this->input->post('nama_potongan'),
                'keterangan' => $this->input->post('keterangan'),
                'nominal' => $this->input->post('nominal_potongan'),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('id'),
            ];

            $insertData = $this->M_referensiPotongan->insert($data, 'gaji_potongan_ref');

            if ($insertData) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array(
                        'status' => 1,
                        'message' => 'Berhasil Tambah Data',
                    )));
            }
        }
    }

    public function edit()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');

            $param = [
                'id' => $id,
            ];
            $data = $this->M_referensiPotongan->get_db('gaji_potongan_ref', $param, 'row');

            if (!empty($data)) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array(
                        'status' => 200,
                        'data' => $data
                    )));
            } else {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array(
                        'status' => 500,
                        'data' => 'Terdapat kesalahan',
                    )));
            }
        } else {
            echo "Tidak dapat memproses data";
        }
    }

    public function update()
    {
        $this->form_validation->set_rules('edit_nama_potongan', 'Nama Potongan', 'required', array(
            'required' => '%s wajib diisi.',
        ));
        $this->form_validation->set_rules('edit_nominal_potongan', 'Nominal Potongan', 'required|numeric', array(
            'required' => '%s wajib diisi.',
            'numeric' => 'diisi angka.',
        ));
        if ($this->form_validation->run() == FALSE) {
            $error_message = array(
                'edit_nama_potongan' => form_error('edit_nama_potongan'),
                'edit_nominal_potongan' => form_error('edit_nominal_potongan'),
            );
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array(
                    'status' => 0,
                    'error_message' => $error_message
                )));
        } else {
            $data = [
                'nama' => $this->input->post('edit_nama_potongan'),
                'keterangan' => $this->input->post('edit_keterangan'),
                'nominal' => $this->input->post('edit_nominal_potongan'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('id'),
            ];

            $param = [
                'id' => $this->input->post('edit_id')
            ];
            $editData = $this->M_referensiPotongan->update($data, $param, 'gaji_potongan_ref');

            if ($editData) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array(
                        'status' => 1,
                        'message' => 'Berhasil Ubah Data',
                    )));
            }
        }
    }

    public function destroy()
    {
        if ($this->input->is_ajax_request()) {
            $data = [
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => $this->session->userdata('id'),
            ];

            $param = [
                'id' => $this->input->post('id'),
            ];

            $hapus = $this->M_referensiPotongan->update($data, $param, 'gaji_potongan_ref');

            if ($hapus) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array(
                        'status' => 1,
                        'message' => 'Berhasil hapus data'
                    )));
            }
        } else {
            echo "Tidak dapat memproses data";
        }
    }
}
