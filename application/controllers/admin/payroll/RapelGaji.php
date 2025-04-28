<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RapelGaji extends CI_Controller
{
    public $db_hrms;

    public function __construct()
    {
        parent::__construct();

        $this->db_hrms = $this->load->database('hrms', TRUE);

        if (($this->session->userdata('logged') != TRUE)
            && ($this->session->userdata('access') != 'payroll_staff')
        ) {
            $url = base_url('login');
            redirect($url);
        };

        $this->load->model('payroll/M_rapelgaji');
        $this->load->model('payroll/M_karyawan');
    }

    public function gaji()
    {
        // $data = $this->M_rapelgaji->data_gaji([
        //     $this->db_hrms->database . ".pegawai.deleted_at IS NULL" => NULL,
        //     $this->db_hrms->database . ".pegawai.status <> 2" => NULL,
        //     $this->db_hrms->database . ".gaji_rapel.bulan" => date('Ym'),
        // ]);
        // echo "<pre>";
        // var_dump($data);
        // echo "</pre>";
        // exit;

        $curYear = date('Y');
        $curMonth = date('m');
        $bulan = $curYear . $curMonth;

        $this->load->view('payroll/rapel_gaji/index', [
            'title' => "Gaji",
            'gaji' => $this->M_rapelgaji->data_gaji([
                $this->db_hrms->database . ".pegawai.deleted_at IS NULL" => NULL,
                $this->db_hrms->database . ".pegawai.status <> 2" => NULL,
            ]),

            'pegawai' => $this->M_karyawan->get_data_pegawai([
                $this->db_hrms->database . ".pegawai.deleted_at IS NULL" => NULL,
                $this->db_hrms->database . ".ref_status_kepegawaian.id <> 15" => NULL,
                $this->db_hrms->database . ".ref_status_kepegawaian.id <> 3" => NULL,
            ]),

            'tahun_gajian' => $this->db->distinct($this->db_hrms->database . ".gaji_generate.bulan")
                ->select(
                    $this->db_hrms->database . ".gaji_generate.bulan as bulan
                "
                )
                ->from($this->db_hrms->database . ".gaji_generate")
                ->not_like($this->db_hrms->database . ".gaji_generate.bulan", $bulan)
                ->order_by($this->db_hrms->database . ".gaji_generate.bulan", "desc")
                ->get()
                ->result_array()
        ]);
    }

    public function gaji_index($bulan = "")
    {
        if (!empty($bulan)) {
            $this->load->view('payroll/rapel_gaji/index', [
                'title' => "Rapel Gaji",

                'gaji' => $this->M_rapelgaji->data_gaji([
                    $this->db_hrms->database . ".pegawai.deleted_at IS NULL" => NULL,
                    $this->db_hrms->database . ".gaji_rapel.bulan" => $bulan,
                    $this->db_hrms->database . ".pegawai.status <> 2" => NULL,
                ]),

                'tahun_gajian' => $this->db->distinct($this->db_hrms->database . ".gaji_generate.bulan")
                    ->select($this->db_hrms->database . ".gaji_generate.bulan as bulan")
                    ->from($this->db_hrms->database . ".gaji_generate")
                    ->not_like($this->db_hrms->database . ".gaji_generate.bulan", date('Y') . date('m'))
                    ->order_by($this->db_hrms->database . ".gaji_generate.bulan", "desc")
                    ->get()
                    ->result_array()
            ]);
        } else {
            echo "Terjadi kesalahan";
        }
    }

    public function store()
    {
        $this->form_validation->set_rules('bulan', 'Bulan', 'required', array('required' => 'Wajib mengisi %s'));
        $this->form_validation->set_rules('pegawai', 'Pegawai', 'required', array('required' => 'Wajib mengisi %s'));
        $this->form_validation->set_rules('rapel_gaji', 'Rapel Gaji', 'required', array('required' => 'Wajib mengisi %s'));
        if ($this->form_validation->run() == FALSE) {
            $error_message = array(
                'bulan' => form_error('bulan'),
                'pegawai' => form_error('pegawai'),
                'rapel_gaji' => form_error('rapel_gaji'),
            );
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array(
                    'status' => 0,
                    'error_message' => $error_message
                )));
        } else {
            // Check rapel gaji untuk orang yang sama di bulan yang sama udah diinput atau gak
            $check_rapel_gaji = $this->db_hrms->get_where('gaji_rapel', [
                'pegawai_id' => $this->input->post('pegawai'),
                'bulan' => $this->input->post('bulan'),
            ])->row();
            if (empty($check_rapel_gaji)) {
                $insert = $this->db->insert($this->db_hrms->database . ".gaji_rapel", [
                    'pegawai_id' => $this->input->post('pegawai'),
                    'bulan' => $this->input->post('bulan'),
                    'gaji_pokok' => $this->input->post('rapel_gaji'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('id'),
                ]);
                if ($insert) {
                    return $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(200)
                        ->set_output(json_encode(array(
                            'type' => 1,
                            'message' => 'Berhasil Tambah Data',
                        )));
                }
            } else {
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

    public function detail_potongan()
    {
        if ($this->input->is_ajax_request()) {
            $pegawai_id = $this->input->post('param');
            $bulan = $this->input->post('bulan');

            $data_pegawai = $this->db->select("
                    " . $this->db_hrms->database . ".pegawai.id as peg_id, 
                    " . $this->db_hrms->database . ".pegawai.nama_depan, 
                    " . $this->db_hrms->database . ".pegawai.nama_tengah, 
                    " . $this->db_hrms->database . ".pegawai.nama_belakang,
                    " . $this->db_hrms->database . ".pegawai.gelar_depan, 
                    " . $this->db_hrms->database . ".pegawai.gelar_belakang
                ")
                ->from($this->db_hrms->database . ".pegawai")
                ->where($this->db_hrms->database . ".pegawai.id", $pegawai_id)
                ->get()
                ->row();
            $detail_potongan = $this->db->select("
                    " . $this->db_hrms->database . ".gaji_potongan_trans.id as gaji_potongan_trans_id,
                    " . $this->db_hrms->database . ".gaji_potongan_ref.id as gaji_potongan_ref_id, 
                    " . $this->db_hrms->database . ".gaji_potongan_ref.kode, 
                    " . $this->db_hrms->database . ".gaji_potongan_ref.nama, 
                    " . $this->db_hrms->database . ".gaji_potongan_ref.nominal,
                    " . $this->db_hrms->database . ".pegawai.id as peg_id, 
                    " . $this->db_hrms->database . ".pegawai.nama_depan, 
                    " . $this->db_hrms->database . ".pegawai.nama_tengah, 
                    " . $this->db_hrms->database . ".pegawai.nama_belakang,
                ")
                ->from($this->db_hrms->database . ".gaji_potongan_trans")
                ->join($this->db_hrms->database . ".gaji_potongan_ref", $this->db_hrms->database . ".gaji_potongan_ref.id = " . $this->db_hrms->database . ".gaji_potongan_trans.potongan_ref_id")
                ->join($this->db_hrms->database . ".pegawai", $this->db_hrms->database . ".pegawai.id = " . $this->db_hrms->database . ".gaji_potongan_trans.pegawai_id")
                ->where($this->db_hrms->database . ".gaji_potongan_trans.pegawai_id", $pegawai_id)
                ->where($this->db_hrms->database . ".gaji_potongan_trans.bulan", $bulan)
                ->get()
                ->result_array();

            $response_data_potongan = '
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama Potongan</th>
                                <th scope="col">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                ';
            $nomer = 1;
            $total_potongan = (int) 0;
            foreach ($detail_potongan as $row) {
                $response_data_potongan .= '<tr>';
                $response_data_potongan .= '    <td><strong>' . $nomer++ . '. </strong></td>';
                $response_data_potongan .= '    <td>' . $row["nama"] . '.</td>';
                $response_data_potongan .= '    <td>' .  format_rupiah($row['nominal']) . '.</td>';
                $response_data_potongan .= '</tr>';

                $total_potongan += $row['nominal'];
            }
            $response_data_potongan .= "
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan='2' class='text-end'><strong>Total Potongan</strong></th>
                                <td><strong>" . format_rupiah($total_potongan) . "</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>";


            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array(
                    'status' => 1,
                    'html' => '
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <td class="col-lg-4 col-md-4 col-xs-4"><strong>Nama Lengkap</strong></td>
                                        <td><strong>:</strong></td>
                                        <td class="col-lg-8 col-md-8 col-xs-8">
                                            <strong>' . nama_lengkap_ucwords($data_pegawai->nama_depan, $data_pegawai->nama_tengah, $data_pegawai->nama_belakang) . '</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-lg-4 col-md-4 col-xs-4"><strong>Gelar</strong></td>
                                        <td><strong>:</strong></td>
                                        <td class="col-lg-8 col-md-8 col-xs-8">
                                            ' . $data_pegawai->gelar_depan . ' ' . $data_pegawai->gelar_belakang . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-lg-4 col-md-4 col-xs-4"><strong>Potongan</strong></td>
                                        <td><strong>:</strong></td>
                                        <td class="col-lg-8 col-md-8 col-xs-8">
                                            ' . $response_data_potongan . '
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    '
                )));
        } else {
            echo "Tidak dapat memproses data";
        }
    }

    public function export_excel($bulan)
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

        $sheet->setCellValue('A1', "Gaji Karyawan Universitas Muhammadiyah Bandung");
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A3', "No");
        $sheet->setCellValue('B3', "Nama");
        $sheet->setCellValue('C3', "Gaji Pokok");
        $sheet->setCellValue('D3', "Tunjangan Jabatan Struktural");
        $sheet->setCellValue('E3', "Uang Kehadiran");
        $sheet->setCellValue('F3', "Lembur");
        $sheet->setCellValue('G3', "Potongan");
        $sheet->setCellValue('H3', "Gaji Bersih");
        $sheet->setCellValue('I3', "Bank");
        $sheet->setCellValue('J3', "Nomor Rekening");
        $sheet->setCellValue('K3', "Status Gaji");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);
        $sheet->getStyle('I3')->applyFromArray($style_col);
        $sheet->getStyle('J3')->applyFromArray($style_col);
        $sheet->getStyle('K3')->applyFromArray($style_col);

        // Panggil function view yang ada di Model untuk menampilkan semua data
        $data_remun = $this->M_rapelgaji->data_gaji([
            $this->db_hrms->database . ".pegawai.deleted_at IS NULL" => NULL,
            $this->db_hrms->database . ".gaji_rapel.bulan" => $bulan,
            $this->db_hrms->database . ".pegawai.status <> 2" => NULL,
            $this->db_hrms->database . ".pegawai.status <> 4" => NULL,
            $this->db_hrms->database . ".pegawai.status <> 5" => NULL,
            $this->db_hrms->database . ".pegawai.status <> 6" => NULL,
        ]);

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($data_remun as $data) { // Lakukan looping pada variabel siswa

            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, nama_lengkap_ucwords($data["nama_depan"], $data["nama_tengah"], $data["nama_belakang"]));
            $sheet->setCellValue('C' . $numrow, $data["gaji_pokok"]);
            // $sheet->setCellValue('D' . $numrow, $data["t_jabatan_struktural"]);
            // $sheet->setCellValue('E' . $numrow, $data["t_absensi"]);
            // $sheet->setCellValue('F' . $numrow, $data["t_lembur"]);
            // $sheet->setCellValue('G' . $numrow, $data["potongan"]);
            // $sheet->setCellValue('H' . $numrow, $data["take_home_pay"]);
            $sheet->setCellValue('D' . $numrow, $data["bank"]);
            $sheet->setCellValue('E' . $numrow, $data["no_rekening"]);
            $sheet->setCellValue('F' . $numrow, $data["status_payment"]);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            // $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
            // $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
            // $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
            // $sheet->getStyle('J' . $numrow)->applyFromArray($style_row);
            // $sheet->getStyle('K' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(30); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(20); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(20); // Set width kolom E
        // $sheet->getColumnDimension('G')->setWidth(20); // Set width kolom E
        // $sheet->getColumnDimension('H')->setWidth(20); // Set width kolom E
        // $sheet->getColumnDimension('I')->setWidth(20); // Set width kolom E
        // $sheet->getColumnDimension('J')->setWidth(20); // Set width kolom E
        // $sheet->getColumnDimension('K')->setWidth(20); // Set width kolom E

        // GET HIGHEST ROW
        $row = $sheet->getHighestRow() + 3;
        $sheet->insertNewRowBefore($row);
        $sheet->setCellValue('A' . $row, 'Diajukan');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->setCellValue('D' . $row, 'Dibayarkan');
        $sheet->getStyle('D' . $row)->getFont()->setBold(true);
        $sheet->setCellValue('F' . $row, 'Menyetujui');
        $sheet->getStyle('F' . $row)->getFont()->setBold(true);

        $row2 = $sheet->getHighestRow() + 1;
        $sheet->insertNewRowBefore($row2);
        $sheet->setCellValue('A' . $row2, 'Kepala Bag. SDM & Adm.Umum');
        $sheet->getStyle('A' . $row2)->getFont()->setBold(false);
        $sheet->setCellValue('D' . $row2, 'Kepala Bagian Keuangan');
        $sheet->getStyle('D' . $row2)->getFont()->setBold(false);
        $sheet->setCellValue('F' . $row2, 'Wakil Rektor II');
        $sheet->getStyle('F' . $row2)->getFont()->setBold(false);

        $row3 = $sheet->getHighestRow() + 5;
        $sheet->insertNewRowBefore($row3);
        $sheet->setCellValue('A' . $row3, 'Mohamad Hilal Numan, S.H.,M.Kn.');
        $sheet->getStyle('A' . $row3)->getFont()->setBold(true);
        $sheet->setCellValue('D' . $row3, 'Abin Suarsa, S.E.,M.M.,CA.');
        $sheet->getStyle('D' . $row3)->getFont()->setBold(true);
        $sheet->setCellValue('F' . $row3, 'Ahmad Diponegoro, M.S.I.E., Ph.D.');
        $sheet->getStyle('F' . $row3)->getFont()->setBold(true);

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $sheet->setTitle("Gaji Karyawan UMBandung");

        // Proses file excel
        $file_name = "payroll_umbandung_" . $bulan . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $file_name . '"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function export_payroll($bulan)
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
        $sheet->setCellValue('A1', "Account Number");
        $sheet->setCellValue('B1', "Amount");
        $sheet->setCellValue('C1', "Message");
        $sheet->setCellValue('D1', "Transfer Type");
        $sheet->setCellValue('E1', "Bank Code");
        $sheet->setCellValue('F1', "Name");
        $sheet->setCellValue('G1', "");
        $sheet->setCellValue('H1', "");
        $sheet->setCellValue('I1', "");
        $sheet->setCellValue('J1', "");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A1')->applyFromArray($style_col);
        $sheet->getStyle('B1')->applyFromArray($style_col);
        $sheet->getStyle('C1')->applyFromArray($style_col);
        $sheet->getStyle('D1')->applyFromArray($style_col);
        $sheet->getStyle('E1')->applyFromArray($style_col);
        $sheet->getStyle('F1')->applyFromArray($style_col);
        $sheet->getStyle('G1')->applyFromArray($style_col);
        $sheet->getStyle('H1')->applyFromArray($style_col);
        $sheet->getStyle('I1')->applyFromArray($style_col);
        $sheet->getStyle('J1')->applyFromArray($style_col);

        // Panggil function view yang ada di Model untuk menampilkan semua data
        $data_remun = $this->M_rapelgaji->data_gaji([
            $this->db_hrms->database . ".pegawai.deleted_at IS NULL" => NULL,
            $this->db_hrms->database . ".pegawai.status <> 2" => NULL,
            $this->db_hrms->database . ".pegawai.status <> 4" => NULL,
            $this->db_hrms->database . ".pegawai.status <> 5" => NULL,
            $this->db_hrms->database . ".pegawai.status <> 6" => NULL,
            $this->db_hrms->database . ".gaji_rapel.bulan" => $bulan,
        ]);

        var_dump($data_remun);
        exit;

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($data_remun as $data) { // Lakukan looping pada variabel siswa
            if ($data["status_payment"] == 'UNPAID') {
                // Update status payment gaji
                $update = $this->db->update(
                    $this->db_hrms->database . ".gaji_rapel",
                    array(
                        'status_payment' => "PAID",
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => $this->session->userdata('id'),
                    ),
                    array(
                        'id' => $data["gaji_generate_id"],
                    )
                );
            }

            $sheet->setCellValue('A' . $numrow, $data["no_rekening"]);
            $sheet->setCellValue('B' . $numrow, $data["take_home_pay"]);
            $sheet->setCellValue('C' . $numrow, "Payroll " . $bulan);
            $sheet->setCellValue('D' . $numrow, "SKN");
            $sheet->setCellValue('E' . $numrow, "Muamalat");
            $sheet->setCellValue('F' . $numrow, nama_lengkap_ucwords($data["nama_depan"], $data["nama_tengah"], $data["nama_belakang"]));
            $sheet->setCellValue('G' . $numrow, "Y");
            $sheet->setCellValue('H' . $numrow, "Y");
            $sheet->setCellValue('I' . $numrow, " ");
            $sheet->setCellValue('J' . $numrow, "perorangan");

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('J' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(15); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(15); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('G')->setWidth(10); // Set width kolom E
        $sheet->getColumnDimension('H')->setWidth(10); // Set width kolom E
        $sheet->getColumnDimension('I')->setWidth(10); // Set width kolom E
        $sheet->getColumnDimension('J')->setWidth(15); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $sheet->setTitle("Gaji Karyawan UMBandung");

        // Proses file excel
        $file_name = "payroll_" . $bulan . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $file_name . '"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function cetak_slip_mpdf($bulan, $pegawai_id)
    {
        $this->load->library('MpdfGenerator');

        // title dari pdf
        $this->data['title'] = 'Slip Gaji';

        // detail pegawai
        $this->data['data_pegawai'] = $this->M_gaji->slip_gaji_data($bulan, $pegawai_id);

        $this->data['data_remun_dosen'] = ([
            'bulan' => $bulan,

            'nama_lengkap' => nama_gelar_lengkap_ucwords(
                $this->data['data_pegawai']->nama_depan,
                $this->data['data_pegawai']->nama_tengah,
                $this->data['data_pegawai']->nama_belakang,
                $this->data['data_pegawai']->gelar_depan,
                $this->data['data_pegawai']->gelar_belakang
            ),
            'tanggal' => tanggal_indonesia(date('Y-m-d'))
        ]);

        $this->data['data_kehadiran_single'] = $this->M_gaji->data_kehadiran_single($pegawai_id, $bulan);
        $this->data['data_lembur_single'] = $this->M_gaji->data_lembur_single($pegawai_id, $bulan);

        $this->data['data_potongan'] = $this->db->select("
                " . $this->db_hrms->database . ".gaji_potongan_ref.id as id_potongan,
                " . $this->db_hrms->database . ".gaji_potongan_ref.nama,
                " . $this->db_hrms->database . ".gaji_potongan_ref.nominal
                ")
            ->from($this->db_hrms->database . ".gaji_potongan_ref")
            ->join($this->db_hrms->database . ".gaji_potongan_trans", $this->db_hrms->database . ".gaji_potongan_trans.potongan_ref_id =" . $this->db_hrms->database . ".gaji_potongan_ref.id")
            ->where($this->db_hrms->database . ".gaji_potongan_trans.pegawai_id", $pegawai_id)
            ->where($this->db_hrms->database . ".gaji_potongan_trans.bulan", $bulan)
            ->get()
            ->result_array();

        $this->data['total_potongan'] = $this->db->select("
            SUM(" . $this->db_hrms->database . ".gaji_potongan_ref.nominal) as nominal_potongan,
                    ")
            ->from($this->db_hrms->database . ".gaji_potongan_ref")
            ->join($this->db_hrms->database . ".gaji_potongan_trans", $this->db_hrms->database . ".gaji_potongan_trans.potongan_ref_id =" . $this->db_hrms->database . ".gaji_potongan_ref.id")
            ->where($this->db_hrms->database . ".gaji_potongan_trans.pegawai_id", $pegawai_id)
            ->where($this->db_hrms->database . ".gaji_potongan_trans.bulan", $bulan)
            ->get()->row();

        // filename dari pdf ketika didownload
        $file_pdf = 'slip gaji';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";

        $html = $this->load->view('payroll/gaji/slip_gaji', $this->data, true);

        $nama_file = 'Slip Gaji - ' . $this->data['data_remun_dosen']["nama_lengkap"] . ' - ' . $bulan . '.pdf';

        // run mpdf
        $this->mpdfgenerator->generate($html, $nama_file);
    }

    function data_for_export($bulan, $pegawai_id)
    {
        // detail pegawai
        $this->data['data_pegawai'] = $this->M_gaji->slip_gaji_data($bulan, $pegawai_id);

        $this->data['data_remun_dosen'] = ([
            'bulan' => $bulan,

            'nama_lengkap' => nama_gelar_lengkap_ucwords(
                $this->data['data_pegawai']->nama_depan,
                $this->data['data_pegawai']->nama_tengah,
                $this->data['data_pegawai']->nama_belakang,
                $this->data['data_pegawai']->gelar_depan,
                $this->data['data_pegawai']->gelar_belakang
            ),
            'tanggal' => tanggal_indonesia(date('Y-m-d'))
        ]);

        $this->data['data_kehadiran_single'] = $this->M_gaji->data_kehadiran_single($pegawai_id, $bulan);
        $this->data['data_lembur_single'] = $this->M_gaji->data_lembur_single($pegawai_id, $bulan);

        $this->data['data_potongan'] = $this->db->select("
                " . $this->db_hrms->database . ".gaji_potongan_ref.id as id_potongan,
                " . $this->db_hrms->database . ".gaji_potongan_ref.nama,
                " . $this->db_hrms->database . ".gaji_potongan_ref.nominal
                ")
            ->from($this->db_hrms->database . ".gaji_potongan_ref")
            ->join($this->db_hrms->database . ".gaji_potongan_trans", $this->db_hrms->database . ".gaji_potongan_trans.potongan_ref_id =" . $this->db_hrms->database . ".gaji_potongan_ref.id")
            ->where($this->db_hrms->database . ".gaji_potongan_trans.pegawai_id", $pegawai_id)
            ->where($this->db_hrms->database . ".gaji_potongan_trans.bulan", $bulan)
            ->get()
            ->result_array();

        $this->data['total_potongan'] = $this->db->select("
                        SUM(" . $this->db_hrms->database . ".gaji_potongan_ref.nominal) as nominal_potongan,
                    ")
            ->from($this->db_hrms->database . ".gaji_potongan_ref")
            ->join($this->db_hrms->database . ".gaji_potongan_trans", $this->db_hrms->database . ".gaji_potongan_trans.potongan_ref_id =" . $this->db_hrms->database . ".gaji_potongan_ref.id")
            ->where($this->db_hrms->database . ".gaji_potongan_trans.pegawai_id", $pegawai_id)
            ->where($this->db_hrms->database . ".gaji_potongan_trans.bulan", $bulan)
            ->get()->row();

        return $this->data;
    }


    public function cetak_slip_excel($bulan, $pegawai_id)
    {
        // Get semua data yang dibutuhkan
        $data_export = $this->data_for_export($bulan, $pegawai_id);

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

        // Insert gambar
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Paid');
        $drawing->setDescription('Paid');
        $drawing->setPath('assets/kop/kop-header.png'); // put your path and image here
        $drawing->setHeight(80);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(320);
        $drawing->getShadow()->setVisible(true);
        $drawing->getShadow()->setDirection(45);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(320);
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(80);

        // $sheet->setCellValue('A1', "Universitas Muhammadiyah Bandung");
        // $sheet->setCellValue('A2', "Alamat");
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A3', "SLIP GAJI DOSEN/KARYAWAN");
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->mergeCells('A3:F3');
        $sheet->setCellValue('A4', "Bulan " . bulan_panjang(substr($data_export["data_remun_dosen"]['bulan'], -2)) . " " . substr($data_export["data_remun_dosen"]['bulan'], 0, 4));
        $sheet->getStyle('A4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A4')->getFont()->setUnderline(true);
        $sheet->getStyle('A4')->getFont()->setBold(true);
        $sheet->mergeCells('A4:F4');


        $sheet->setCellValue('A6', "Nama");
        $sheet->setCellValue('A7', "Pangkat / Golongan");
        $sheet->setCellValue('A8', "Status");
        $sheet->setCellValue('A9', "Jabatan Akademik");
        $sheet->setCellValue('A10', "Jabatan Struktural");

        $sheet->setCellValue('B6', ":");
        $sheet->setCellValue('B7', ":");
        $sheet->setCellValue('B8', ":");
        $sheet->setCellValue('B9', ":");
        $sheet->setCellValue('B10', ":");

        // Set value for nama
        $sheet->setCellValue('C6', $data_export["data_remun_dosen"]["nama_lengkap"]);
        $sheet->setCellValue('C7', $data_export["data_pegawai"]->golongan . " / " . $data_export["data_pegawai"]->pangkat);
        $sheet->setCellValue('C8', $data_export["data_pegawai"]->status_kepegawaian_nama);
        $sheet->setCellValue('C9', $data_export["data_pegawai"]->nama_jabatan . " - " . $data_export["data_pegawai"]->angka_kredit);
        $sheet->setCellValue('C10', $data_export["data_pegawai"]->j_struktural);

        $sheet->setCellValue('A12', "PENGHASILAN");
        $sheet->getStyle('A12')->getFont()->setBold(true);
        $sheet->getStyle('A12')->getFont()->setUnderline(true);
        $sheet->mergeCells('A12:B12');
        $sheet->setCellValue('A13', "Gaji Pokok");
        $sheet->setCellValue('A14', "Tunjangan Jabatan Struktural");
        $sheet->setCellValue('A15', "Tunjangan Kehadiran");
        $sheet->setCellValue('A16', "Tunjangan Lembur");
        $sheet->setCellValue('A17', "TOTAL PENGHASILAN (A)");
        $sheet->getStyle('A17')->getFont()->setBold(true);

        $sheet->setCellValue('B13', ":");
        $sheet->setCellValue('B14', ":");
        $sheet->setCellValue('B15', ":");
        $sheet->setCellValue('B16', ":");
        $sheet->setCellValue('B17', ":");
        $sheet->getStyle('B17')->getFont()->setBold(true);

        $sheet->setCellValue('C13', format_rupiah($data_export["data_pegawai"]->nominal_gaji));
        $sheet->setCellValue('C14', format_rupiah($data_export["data_pegawai"]->gaji_generate_t_jabatan_struktural));
        $tunjangan_kehadiran = empty($data_export["data_kehadiran_single"]->total) ? 0 :  $data_export["data_kehadiran_single"]->total;
        $sheet->setCellValue('C15', format_rupiah($tunjangan_kehadiran));
        $tunjangan_lembur =  0;
        if (empty($data_export["data_lembur_single"]->total_nilai) && empty($data_export["data_lembur_single"]->nilai_bulk)) {
            $tunjangan_lembur =  0;
        } else if (!empty($data_export["data_lembur_single"]->total_nilai)) {
            $tunjangan_lembur = $data_export["data_lembur_single"]->total_nilai;
        } else if (!empty($data_export["data_lembur_single"]->nilai_bulk)) {
            $tunjangan_lembur = $data_export["data_lembur_single"]->nilai_bulk;
        }
        $sheet->setCellValue('C16', format_rupiah($tunjangan_lembur));
        $jumlah_penghasilan = $data_export["data_pegawai"]->nominal_gaji +
            $data_export["data_pegawai"]->gaji_generate_t_jabatan_struktural +
            $tunjangan_kehadiran + $tunjangan_lembur;
        $sheet->setCellValue('C17', format_rupiah($jumlah_penghasilan));
        $sheet->getStyle('C17')->getFont()->setBold(true);


        $sheet->setCellValue('D12', "POTONGAN");
        $sheet->getStyle('D12')->getFont()->setBold(true);
        $sheet->getStyle('D12')->getFont()->setUnderline(true);
        $sheet->mergeCells('D12:D12');
        $no_potongan = 13;
        foreach ($data_export["data_potongan"] as $row) {
            $sheet->setCellValue('D' . $no_potongan, ucwords($row["nama"]));
            $sheet->setCellValue('E' . $no_potongan, ":");
            $sheet->setCellValue('F' . $no_potongan, format_rupiah($row["nominal"]));
            $no_potongan++;
        }
        $sheet->setCellValue('D' . ($no_potongan + 2), "TOTAL POTONGAN (B)");
        $sheet->getStyle('D' . ($no_potongan + 2))->getFont()->setBold(true);
        $sheet->setCellValue('E' . ($no_potongan + 2), ":");
        $sheet->getStyle('E' . ($no_potongan + 2))->getFont()->setBold(true);
        $sheet->setCellValue('F' . ($no_potongan + 2), format_rupiah($data_export["total_potongan"]->nominal_potongan));
        $sheet->getStyle('F' . ($no_potongan + 2))->getFont()->setBold(true);

        $gaji_bersih = $jumlah_penghasilan - $data_export["total_potongan"]->nominal_potongan;
        $sheet->setCellValue('A' . ($no_potongan + 4), "PENERIMAAN BERSIH (A - B) : " . format_rupiah($gaji_bersih));
        $sheet->mergeCells('A' . ($no_potongan + 4) . ':' . 'F' . ($no_potongan + 4));
        $sheet->getStyle('A' . ($no_potongan + 4))->getFont()->setBold(true);
        $sheet->getStyle('A' . ($no_potongan + 4))->getAlignment()->setHorizontal('center');
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A' . ($no_potongan + 4) . ':' . 'F' . ($no_potongan + 4))
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('D3D3D3');

        $sheet->setCellValue('A' . ($no_potongan + 5), ucwords(\Nasution\Terbilang::convert($gaji_bersih)) . " Rupiah");
        $sheet->mergeCells('A' . ($no_potongan + 5) . ':' . 'F' . ($no_potongan + 5));
        $sheet->getStyle('A' . ($no_potongan + 5))->getFont()->setBold(true);
        $sheet->getStyle('A' . ($no_potongan + 5))->getAlignment()->setHorizontal('center');
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A' . ($no_potongan + 5) . ':' . 'F' . ($no_potongan + 5))
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('D3D3D3');

        $sheet->setCellValue('E' . ($no_potongan + 7), "Bandung, " . bulan_panjang(substr($data_export["data_remun_dosen"]['bulan'], -2)) . " " . substr($data_export["data_remun_dosen"]['bulan'], 0, 4));
        $sheet->setCellValue('E' . ($no_potongan + 8), "Kepala Bagian Keuangan");
        $sheet->setCellValue('E' . ($no_potongan + 9), "");
        $sheet->setCellValue('E' . ($no_potongan + 10), "");
        $sheet->setCellValue('E' . ($no_potongan + 11), "");
        $sheet->setCellValue('E' . ($no_potongan + 12), "Abin Suarsa, SE., MM., CESF., CSRS.");
        $sheet->getStyle('E' . ($no_potongan + 12))->getFont()->setBold(true);
        $sheet->getStyle('E' . ($no_potongan + 12))->getFont()->setUnderline(true);

        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(25); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(2); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(20); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(25); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(2); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(20); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $sheet->setTitle("Gaji Karyawan UMBandung");

        // Proses file excel
        $file_name = "slipgaji_" . $bulan . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $file_name . '"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
