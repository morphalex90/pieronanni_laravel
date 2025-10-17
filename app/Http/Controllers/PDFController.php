<?php

namespace App\Http\Controllers;

use App\Models\Click;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use Spatie\Browsershot\Browsershot;

class PDFController extends Controller
{
    public function cv(Request $request): void
    {
        Click::create([
            'user_agent' => $request->userAgent(),
        ]);

        $stylesheet = file_get_contents(public_path('css/cv.css'));

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

    public function cv2(Request $request)
    {
        // Click::create([
        //     'user_agent' => $request->userAgent(),
        // ]);

        $jobs = Cache::rememberForever('jobs_with_projects_technologies', function () {
            return Job::with('projects.technologies')->orderBy('started_at', 'DESC')->get();
        });

        $html = view('pdf.cv-tailwind', ['jobs' => $jobs]);

        $pdf = Browsershot::html($html->render())
            ->noSandbox()
            // ->setOption('pdf.info.Author', 'Piero Nanni')
            ->showBrowserHeaderAndFooter()
            ->headerHtml(' ')
            ->format('A4')
            ->showBackground()
            ->footerHtml('<div style="text-align: center;"><span class="pageNumber">blabla</span> / <span class="date"></span></div>'); // https://github.com/spatie/browsershot/discussions/617

        return Response::make($pdf->pdf(), headers: [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="cv_piero_nanni.pdf"',
        ]);
    }
}
