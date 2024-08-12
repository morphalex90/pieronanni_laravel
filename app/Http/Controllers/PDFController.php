<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PDFController extends Controller
{
    /**
     * Display PDF CV.
     */
    public function cv()
    {

        $output = 'test pdf';


        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => '../tmp',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'default_font' => 'calibri'
        ]);
        $mpdf->SetTitle('Curriculum Vitae Piero Nanni');
        $mpdf->SetAuthor("Piero Nanni");

        $mpdf->WriteHTML($output);

        $mpdf->Output('cv_piero_nanni.pdf', \Mpdf\Output\Destination::INLINE);
    }
}
