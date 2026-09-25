<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\PurgeCache;
use App\Models\Click;
use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response as ResponseFactory;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use Spatie\Browsershot\Browsershot;

final class PDFController extends Controller
{
    /**
     * The CV is rendered from a local file with its CSS inlined, so it needs no
     * network access. Blocking every remote scheme stops content in the page
     * from reaching internal services (SSRF) or exfiltrating data.
     *
     * @var list<string>
     */
    private const BLOCKED_URL_SCHEMES = ['http://', 'https://', 'ws://', 'wss://', 'ftp://'];

    public function cv(Request $request): Response
    {
        Click::create([
            'user_agent' => $request->userAgent(),
        ]);

        $html = view('pdf.cv-tailwind', ['jobs' => $this->jobsWithProjectsAndTechnologies()]);

        $pdf = Browsershot::html($html->render())
            ->disableJavascript()
            ->blockUrls(self::BLOCKED_URL_SCHEMES)
            // ->setOption('pdf.info.Author', 'Piero Nanni')
            ->showBrowserHeaderAndFooter()
            ->headerHtml(' ')
            ->format('A4')
            ->showBackground();
        // ->footerHtml('<div style="text-align: center;"><span class="pageNumber">blabla</span> / <span class="date"></span></div>'); // https://github.com/spatie/browsershot/discussions/617

        // Keep Chromium's sandbox unless the host genuinely cannot provide it
        // (e.g. running as root in a container). Prefer fixing the host.
        if (config('services.browsershot.no_sandbox')) {
            $pdf->noSandbox();
        }

        return $this->pdfResponse($pdf->pdf());
    }

    public function cvOld(): Response
    {
        $stylesheet = (string) file_get_contents(public_path('css/cv.css'));

        $html = view('pdf.cv-old', ['jobs' => $this->jobsWithProjectsAndTechnologies()]);

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
        $mpdf->WriteHTML($html->render(), HTMLParserMode::HTML_BODY);

        // Superseded by /cv; kept reachable but out of search results so the two CVs don't compete.
        return $this->pdfResponse((string) $mpdf->Output('cv_piero_nanni.pdf', Destination::STRING_RETURN))
            ->header('X-Robots-Tag', 'noindex');
    }

    /**
     * @return Collection<int, Job>
     */
    private function jobsWithProjectsAndTechnologies(): Collection
    {
        return Cache::remember(
            PurgeCache::key(PurgeCache::JOBS_WITH_PROJECTS_TECHNOLOGIES),
            PurgeCache::TTL,
            function () {
                return Job::query()->with('projects.technologies')->orderBy('started_at', 'desc')->get();
            }
        );
    }

    /**
     * Return the PDF bytes through Laravel's response pipeline so middleware
     * (security headers, CSP) still applies, instead of echoing them directly.
     */
    private function pdfResponse(string $bytes): Response
    {
        return ResponseFactory::make($bytes, headers: [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="cv_piero_nanni.pdf"',
        ]);
    }
}
