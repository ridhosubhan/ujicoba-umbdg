<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiKKN extends REST_Controller
{
    public $db_hrms;

    function __construct()
    {
        parent::__construct();

        $this->db_hrms = $this->load->database('hrms', TRUE);
        $this->db_akademik = $this->load->database('akademik', TRUE);
        $this->db_keuangan_payment = $this->load->database('keuangan_payment', TRUE);
    }

    // Function API untuk trigger potongan perbulan
    function auth()
    {
        $api_key = 'H79XGeV87xnOe8g';

        if ($this->getPost('key') == $api_key) {
            return true;
        } else {
            return $this->response(['success' => false], 400);
        }
    }

    // Cek mahasiswa yang sudah mengambil krs mata kuliah KKN
    public function check_krs()
    {
        if ($this->auth()) {
            $nim = $this->getPost('nim');
            $semester = $this->getPost('semester');

            $data_validation = ([
                'nim' => $nim,
                'semester' => $semester,
            ]);

            $this->form_validation->set_data($data_validation);
            $this->form_validation->set_rules('nim', 'nim', 'required', array(
                'required' => '%s wajib diisi.',
            ));
            $this->form_validation->set_rules('semester', 'semester', 'required', array(
                'required' => '%s wajib diisi.',
            ));
            if ($this->form_validation->run() == FALSE) {
                $error_message = array(
                    'nim' => form_error('nim'),
                    'semester' => form_error('semester'),
                );
                return $this->response(['success' => false, 'error_message' => $error_message], 500);
            } else {
                $krs = $this->db_akademik->get_where('ak_krs', [
                    'nim' => $nim,
                    'semester_mhs' => $semester,
                    'status' => 'Y',
                ])->result_array();

                // check if data not found
                if (!empty($krs)) {
                    $i = 0;
                    $data_return = [];
                    foreach ($krs as $item) {
                        $jadwal = $this->db_akademik->select('
                            ak_jadwal.id_jadwal, ak_matkul.id_matkul, ak_matkul.nama, ak_matkul.status')
                            ->from('ak_jadwal')
                            ->join('ak_matkul', 'ak_matkul.id_matkul = ak_jadwal.id_matkul')
                            ->where('id_jadwal', $item['id_jadwal'])
                            ->where('status', 'Y')
                            ->get()->row();
                        if (!empty($jadwal)) {
                            if ((strpos($jadwal->nama, 'KKN') !== false) || (strpos($jadwal->nama, 'Kuliah Kerja Nyata') !== false)) {
                                $data_return = 'true';
                            }
                        }
                    }

                    if (!empty($data_return)) {
                        return $this->response(['message' => true], 200);
                    } else {
                        return $this->response(['message' => false], 200);
                    }
                } else {
                    return $this->response(['success' => false, 'message' => 'Data not found'], 200);
                }
            }
        }
    }

    // Cek mahasiswa yang sudah bayar KKN
    public function check_payment_kkn()
    {
        if ($this->auth()) {
        }
    }
}
