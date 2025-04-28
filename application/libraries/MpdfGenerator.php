<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once FCPATH . '/vendor/autoload.php';

use Mpdf\Mpdf;

class MpdfGenerator
{
    public function generate($html, $file_name)
    {
        // $path = 'vendor/mpdf/mpdf/tmp'; // You should change this as prefered.
        // if (!file_exists($path)) {
        //     mkdir($path, 0777, true);
        // }

        // $mpdf = new Mpdf();
        $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir()]);
        $mpdf->WriteHTML($html);
        $mpdf->Output($file_name, 'I');
    }
}
