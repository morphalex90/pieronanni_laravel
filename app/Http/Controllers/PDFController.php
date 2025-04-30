<?php

namespace App\Http\Controllers;

use App\Models\Click;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

class PDFController extends Controller
{
    /**
     * Display PDF CV.
     */
    public function cv(Request $request)
    {
        Click::create([
            'user_agent' => $request->userAgent(),
        ]);

        $stylesheet = file_get_contents('css/cv.css');

        $jobs = Cache::rememberForever('jobs_with_projects_technologies', function () {
            return Job::with('projects.technologies')->orderBy('started_at', 'DESC')->get();
        });

        $html = view('pdf.cv', ['jobs' => $jobs]);

        $mpdf = new Mpdf([
            'tempDir' => storage_path('app/private'),
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 5,
            'margin_bottom' => 5,
            'default_font' => 'calibri',

            'margin_footer' => 5,

            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' / ',
            'nbpgSuffix' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', // add margin right to pagination
        ]);

        $mpdf->defaultfooterline = 0;
        $mpdf->SetTitle('CV Piero Nanni');
        $mpdf->SetAuthor('Piero Nanni');
        $mpdf->setFooter('{PAGENO}{nbpg}');

        $mpdf->WriteHTML($stylesheet, HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, HTMLParserMode::HTML_BODY);

        $mpdf->Output('cv_piero_nanni.pdf', Destination::INLINE);
    }
}
