<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CorePotongan extends CI_Controller
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
        $data = [
            'title' => "Data Potongan Pegawai",
            'pegawai' => $this->M_potongan->get_data_pegawai([
                $this->db_hrms->database . ".pegawai.deleted_at IS NULL" => NULL,
                $this->db_hrms->database . ".ref_status_kepegawaian.id <> 15" => NULL,
                $this->db_hrms->database . ".ref_status_kepegawaian.id <> 3" => NULL,
            ]),

        ];
        $this->load->view('payroll/potongan/potongan_pegawai', $data);
    }

    public function detail($id)
    {
        $data = [
            'title' => "Detail Dosen",
            'prodi' => $this->M_potongan->get_db('prodi'),
            'golongan_pangkat' => $this->M_potongan->get_db('golongan_pangkat'),
            'ref_status_kepegawaian' => $this->M_potongan->get_db('ref_status_kepegawaian'),
            'ref_status_keaktifan' => $this->M_potongan->get_db('ref_status_keaktifan'),
            'ref_agama' => $this->M_potongan->get_db('ref_agama'),
            'ref_potongan' => $this->db_hrms->order_by('created_at', 'DESC')->get('gaji_potongan_ref')->result_array(),

            'profil' => $this->M_potongan->profil($id),

            'tunjangan' => $this->M_potongan->get_tunjangan($id),

            'potongan' => $this->db->select('
                gaji_potongan_ref.id as gaji_potongan_ref_id,
                gaji_potongan_ref.nama,
                gaji_potongan_ref.nominal,
                
                gaji_potongan_trans.id as gaji_potongan_trans_id,
                gaji_potongan_trans.pegawai_id,
                gaji_potongan_trans.bulan,
                ')
                ->from($this->db_hrms->database . ".gaji_potongan_ref")
                ->join($this->db_hrms->database . ".gaji_potongan_trans", $this->db_hrms->database . ".gaji_potongan_trans.potongan_ref_id =" . $this->db_hrms->database . ".gaji_potongan_ref.id")
                ->where($this->db_hrms->database . ".gaji_potongan_trans.pegawai_id", $id)
                ->order_by($this->db_hrms->database . ".gaji_potongan_trans.bulan", "desc")
                ->get()->result_array(),
            'tahun_gajian' => $this->db_hrms->distinct('gaji_generate.bulan')
                ->select('
                    gaji_generate.bulan as bulan
                ')
                ->from('gaji_generate')
                ->order_by("gaji_generate.bulan", "desc")
                ->get()
                ->result_array()
        ];
        $this->load->view('payroll/potongan/detail_potongan_pegawai', $data);
    }


    public function get_potongan()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('potongan-id');

            $param = [
                'id' => $id,
            ];
            $data = $this->M_potongan->get_db('gaji_potongan_trans', $param, 'row');

            if (!empty($data)) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array(
                        'type' => 1,
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

    public function add_potongan()
    {
        if ($this->input->post('tipe-edit') == 'tambah-potongan-dosen') {
            $this->form_validation->set_rules('bulan_potongan', 'Bulan', 'required', array('required' => 'Wajib mengisi %s'));
            $this->form_validation->set_rules('potongan', 'Potongan', 'required', array('required' => 'Wajib mengisi %s'));
            $this->form_validation->set_rules('potongan_perbulan', 'Potongan Perbulan', 'required', array('required' => 'Wajib mengisi %s'));
            if ($this->form_validation->run() == FALSE) {
                $error_message = array(
                    'bulan_potongan' => form_error('bulan_potongan'),
                    'potongan' => form_error('potongan'),
                    'potongan_perbulan' => form_error('potongan_perbulan'),
                );
                $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array(
                        'status' => 0,
                        'error_message' => $error_message
                    )));
            } else {
                // Check potongan dosen active
                if ($this->input->post('potongan_perbulan') == 1) {
                    $check_gaji_potongan_aktif = $this->db_hrms->get_where('gaji_potongan_aktif', [
                        'pegawai_id' => $this->input->post('pegawai_id'),
                        'potongan_ref_id' => $this->input->post('ref_potongan'),
                    ])->row();
                    if (empty($check_gaji_potongan_aktif)) {
                        $insertPotonganDosen = $this->db->insert($this->db_hrms->database . ".gaji_potongan_aktif", [
                            'pegawai_id' => $this->input->post('pegawai_id'),
                            'potongan_ref_id' => $this->input->post('potongan'),
                            'is_active' => $this->input->post('potongan_perbulan'),
                        ]);
                    }
                }

                $potonganDosen = ([
                    'pegawai_id ' =>  $this->input->post('pegawai_id'),
                    'potongan_ref_id ' => $this->input->post('potongan'),
                    'bulan' => $this->input->post('bulan_potongan'),
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $insertPotonganDosen = $this->db->insert($this->db_hrms->database . ".gaji_potongan_trans", $potonganDosen);
                if ($insertPotonganDosen) {
                    return $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(200)
                        ->set_output(json_encode(array(
                            'type' => 1,
                            'message' => 'Berhasil Tambah Data',
                        )));
                }
            }
        }
    }

    public function destroy_potongan()
    {
        if ($this->input->is_ajax_request()) {
            $check_gaji_potongan_aktif = $this->db_hrms->get_where('gaji_potongan_aktif', [
                'pegawai_id' => $this->input->post('pegawai'),
                'potongan_ref_id' => $this->input->post('ref_potongan'),
            ])->row();

            if (!empty($check_gaji_potongan_aktif)) {
                $hapus_gaji_potongan_aktif = $this->M_potongan->delete(
                    [
                        'pegawai_id' => $check_gaji_potongan_aktif->pegawai_id,
                        'potongan_ref_id' => $check_gaji_potongan_aktif->potongan_ref_id,
                    ],
                    'gaji_potongan_aktif'
                );
            }

            $param = [
                'id' => $this->input->post('id'),
            ];

            $hapus = $this->M_potongan->delete(
                $param,
                'gaji_potongan_trans'
            );

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

    public function get_rekening()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('rekening-id');

            $param = [
                'id' => $id,
            ];
            $data = $this->M_potongan->get_db('pegawai_rekening', $param, 'row');

            if (!empty($data)) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array(
                        'type' => 1,
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

    public function update_rekening()
    {
        $this->form_validation->set_rules('no_rekening', 'No. Rekening', 'required', array(
            'required' => '%s wajib diisi.',
        ));
        $this->form_validation->set_rules('bank', 'Bank', 'required', array(
            'required' => '%s wajib diisi.',
        ));
        if ($this->form_validation->run() == FALSE) {
            $error_message = array(
                'no_rekening' => form_error('no_rekening'),
                'bank' => form_error('bank'),
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
                'no_rekening' => $this->input->post('no_rekening'),
                'bank' => $this->input->post('bank'),
                'keterangan' => $this->input->post('keterangan'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $param = [
                'id' => $this->input->post('rekening_id')
            ];
            $editData = $this->M_potongan->update($data, $param, 'pegawai_rekening');

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
}
