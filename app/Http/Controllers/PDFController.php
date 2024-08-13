<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Support\Facades\URL;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

class PDFController extends Controller
{
    /**
     * Display PDF CV.
     */
    public function cv()
    {
        $stylesheet = file_get_contents('css/cv.css');

        $jobs = Job::with('projects.technologies')->orderBy('started_at', 'DESC')->get();

        $html = view('pdf.cv', ['jobs' => $jobs]);

        $mpdf = new Mpdf([
            'tempDir' => '../tmp',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'default_font' => 'calibri'
        ]);
        $mpdf->SetTitle('Curriculum Vitae Piero Nanni');
        $mpdf->SetAuthor("Piero Nanni");

        $mpdf->WriteHTML($stylesheet, HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, HTMLParserMode::HTML_BODY);

        $mpdf->Output('cv_piero_nanni.pdf', Destination::INLINE);
    }
}
