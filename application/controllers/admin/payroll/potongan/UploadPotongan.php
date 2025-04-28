<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UploadPotongan extends CI_Controller
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
        $curYear = date('Y');
        $curMonth = date('m');
        $bulan = $curYear . $curMonth;

        $data = [
            'title' => "Data Potongan Pegawai",
            'tahun_gajian' => $this->db->distinct($this->db_hrms->database . ".gaji_generate.bulan")
                ->select(
                    $this->db_hrms->database . ".gaji_generate.bulan as bulan
                "
                )
                ->from($this->db_hrms->database . ".gaji_generate")
                ->not_like($this->db_hrms->database . ".gaji_generate.bulan", $bulan)
                ->order_by($this->db_hrms->database . ".gaji_generate.bulan", "desc")
                ->get()
                ->result_array(),
            'ref_potongan' => $this->db_hrms->order_by('created_at', 'DESC')->get('gaji_potongan_ref')->result_array(),
        ];
        $this->load->view('payroll/potongan/upload/index', $data);
    }

    public function export_template_potongan()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        // $sheet->setCellValue('A1', "Gaji Karyawan Universitas Muhammadiyah Bandung");
        // $sheet->mergeCells('A1:E1');
        // $sheet->getStyle('A1')->getFont()->setBold(true);
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A1', "Pegawai id");
        $sheet->setCellValue('B1', "Nama Pegawai");
        $sheet->setCellValue('C1', "Tambahkan Potongan (ya/tidak)");
        $sheet->setCellValue('D1', "Potong Perbulan (ya/tidak)");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A1')->applyFromArray($style_col);
        $sheet->getStyle('B1')->applyFromArray($style_col);
        $sheet->getStyle('C1')->applyFromArray($style_col);
        $sheet->getStyle('D1')->applyFromArray($style_col);

        // Panggil function view yang ada di Model untuk menampilkan semua data
        $data_pegawai =  $this->M_potongan->get_data_pegawai([
            $this->db_hrms->database . ".pegawai.deleted_at IS NULL" => NULL,
            $this->db_hrms->database . ".ref_status_kepegawaian.id <> 15" => NULL,
            $this->db_hrms->database . ".ref_status_kepegawaian.id <> 3" => NULL,
        ]);

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($data_pegawai as $data) { // Lakukan looping pada variabel siswa
            $sheet->setCellValue('A' . $numrow, $data["peg_id"]);
            $sheet->setCellValue('B' . $numrow, nama_lengkap_ucwords(
                $data["nama_depan"],
                $data["nama_tengah"],
                $data["nama_belakang"]
            ));
            $sheet->setCellValue('C' . $numrow, "");
            $sheet->setCellValue('D' . $numrow, "");

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(10); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(25); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(30); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(30); // Set width kolom D

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $sheet->setTitle("potongan");

        // Proses file excel
        $file_name = "template_upload_potongan.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $file_name . '"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    function cek_dokumen_excel($str, $file_input)
    {
        $allowed_mime_type_arr = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $mime = get_mime_by_extension($_FILES[$file_input]['name']);

        if (isset($_FILES[$file_input]['name']) && $_FILES[$file_input]['name'] != "") {
            if ($_FILES[$file_input]['size'] <= 2000000) {
                if (!in_array($mime, $allowed_mime_type_arr)) {
                    $this->form_validation->set_message('cek_dokumen_excel', 'Hanya Dokumen Excel yang diizinkan.');
                    return false;
                }
            }
            // else if ($_FILES[$file_input]['size'] > 2000000) {
            //     $this->form_validation->set_message('cek_dokumen_excel', 'Ukuran file terlalu besar, maksimal 2 MB');
            //     return false;
            // }
        } else {
            $this->form_validation->set_message('cek_dokumen_excel', 'Anda belum mengunggah dokumen');
            return false;
        }
    }

    public function upload_excel()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('bulan', 'Bulan', 'required', array(
                'required' => '%s wajib diisi.'
            ));
            $this->form_validation->set_rules('jenis_potongan', 'Jenis Potongan', 'required', array(
                'required' => '%s wajib diisi.'
            ));
            $this->form_validation->set_rules('upload_potongan', 'Dokumen', 'callback_cek_dokumen_excel[upload_potongan]');
            if ($this->form_validation->run() == FALSE) {
                $error_message = array(
                    'bulan' => form_error('bulan'),
                    'jenis_potongan' => form_error('jenis_potongan'),
                    'upload_potongan' => form_error('upload_potongan')
                );
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode([
                        'status' => 0,
                        'error_message' => $error_message
                    ]));
            } else {
                $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

                if (isset($_FILES['upload_potongan']['name']) && in_array($_FILES['upload_potongan']['type'], $file_mimes)) {
                    $arr_file = explode('.', $_FILES['upload_potongan']['name']);
                    $extension = end($arr_file);
                    if ('csv' == $extension) {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                    } elseif ('xls' == $extension) {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                    } else {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                    }
                    $spreadsheet = $reader->load($_FILES['upload_potongan']['tmp_name']);
                    $sheetData = $spreadsheet->getActiveSheet()->toArray();


                    // echo "<pre>";
                    // var_dump($sheetData);
                    // echo "</pre>";
                    // exit;

                    if (!empty($sheetData)) {
                        $i = 0;
                        for ($i = 1; $i < count($sheetData); $i++) {
                            $pegawai_id = $sheetData[$i][0];
                            $aksi_potongan = strtolower($sheetData[$i][2]);
                            $perbulan = strtolower($sheetData[$i][3]);

                            if (in_array($aksi_potongan, ['ya', 'yes', '1', 1, 'true', true])) {
                                // insert potongan untuk bulan selanjutnya
                                if (in_array($perbulan, ['ya', 'yes', '1', 1, 'true', true])) {
                                    // insert ke table gaji potongan aktif untuk trigger cron
                                    $check_potongan_active = $this->db_hrms->get_where('gaji_potongan_aktif', [
                                        'pegawai_id' => $pegawai_id,
                                        'potongan_ref_id' => $this->input->post('jenis_potongan')
                                    ])->row();
                                    if (empty($check_potongan_active)) {
                                        $insert_data_potongan_active = $this->db_hrms->insert('gaji_potongan_aktif', [
                                            'pegawai_id' => $pegawai_id,
                                            'potongan_ref_id' => $this->input->post('jenis_potongan'),
                                            'is_active' => 1
                                        ]);
                                    }

                                    // insert ke table gaji_potongan_trans untuk data payroll
                                    $insert = $this->db_hrms->insert(
                                        'gaji_potongan_trans',
                                        [
                                            'pegawai_id' => $pegawai_id,
                                            'bulan' => $this->input->post('bulan'),
                                            'potongan_ref_id' => $this->input->post('jenis_potongan'),
                                            'created_at' => date('Y-m-d H:i:s'),
                                        ]
                                    );
                                } else {
                                    // insert ke table gaji_potongan_trans untuk data payroll
                                    $insert = $this->db_hrms->insert(
                                        'gaji_potongan_trans',
                                        [
                                            'pegawai_id' => $pegawai_id,
                                            'bulan' => $this->input->post('bulan'),
                                            'potongan_ref_id' => $this->input->post('jenis_potongan'),
                                            'created_at' => date('Y-m-d H:i:s'),
                                        ]
                                    );
                                }
                            }
                        }

                        if ($i > 1) {
                            return $this->output
                                ->set_content_type('application/json')
                                ->set_status_header(200)
                                ->set_output(json_encode(array(
                                    'status' => 1,
                                    'message' => 'Berhasil Import Data',
                                )));
                        }
                    }
                }
            }
        } else {
            echo "Maaf tidak bisa proses data";
        }
    }
}
