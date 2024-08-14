{{-- <link rel="stylesheet" href="{{ URL::asset('css/cv.css') }}" /> --}}

<div>
    <div class="col-6">
        <div style="margin-left:20px; margin-right:20px; padding-top: 15px;">
            <div style="font-size:35px; font-weight:bold; line-height:1px; margin-bottom: 10px;">Piero Nanni</div>
            <div>Full stack developer</div>
            <div style="margin-bottom:10px"><a href="https://www.pieronanni.me">www.pieronanni.me</a></div>
            {{-- <div><em>I don&rquo;t know, it&rquo;s something about web developing that calms me down, ya know?</em></div> --}}
        </div>
    </div>

    <div class="col-6 text-right">
        <div style="margin-left:20px; margin-right:20px;">
            <div>London, UK</div>
            <div>+44 7724 146851</div>
            <div><a href="mailto:piero.nanni@gmail.com">piero.nanni@gmail.com</a></div>
            <div><a href="https://github.com/morphalex90">github.com/morphalex90</a></div>
        </div>
    </div>

    <div class="clear"></div>

    <div style="height: 2px; width: 100%; border-bottom: 2px solid #000;"></div>

    <div class="col-9">
        <div style="margin-left: 20px; border-right: 2px solid #000; padding-right: 20px;">

            <div class="section"><strong>WORK EXPERIENCE</strong></div>
            @foreach ($jobs as $job)
                <div style="border-bottom:1px solid darkgrey;">
                    <div style="margin-top: 20px;"><strong style="font-size: 19px;">{{ $job->title }}</strong></div>
                    <div class="col-6"><a href={{ $job->company['url'] }}>{{ $job->company['name'] }}</a>
                        (<i>{{ $job->location }}</i>)
                    </div>
                    <div class="col-6"><i>{{ Carbon\Carbon::parse($job->started_at)->format('F Y') }}
                            - {{ Carbon\Carbon::parse($job->ended_at)->format('F Y') }}</i></div>
                    <div class="clear"></div>
                    {{-- <br> --}}

                    <div class="job-description">
                        <x-markdown>
                            {!! $job->description_cv !!}
                        </x-markdown>
                    </div>

                    <ul class="project-list">
                        @foreach ($job->projects as $project)
                            <li>
                                {{-- {{ Inertia\Inertia::HTML('Icon', ['technology' => $project->technologies[0]->name]) }} --}}
                                {{-- <img src="" alt={{ $project->title }} title={{ $project->title }} height="15"
                                    width="15"> --}}
                                <span><a href={{ $project->url }}>{{ $project->title }}</a> - blabla project
                                    description</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-3">
        <div style="margin-left: 20px; margin-right: 20px">

            <div class="section"><strong>TECHNICAL SKILLS</strong></div>

            <ul>
                <li>Languages
                    <ul>
                        <li>PHP</li>
                        <li>HTML5</li>
                        <li>JS & TS</li>
                        <li>CSS3, Sass & BEM</li>
                        <li>SQL</li>
                    </ul>
                </li>

                <li>CMS
                    <ul>
                        <li>WordPress</li>
                        <li>Drupal 6, 7, 8, 9</li>
                    </ul>
                </li>

                <li>Frameworks
                    <ul>
                        <li>Laravel</li>
                        <li>Next.js</li>
                    </ul>
                </li>

                <li>Libraries
                    <ul>
                        <li>Bootstrap</li>
                        <li>React</li>
                        <li>jQuery</li>
                    </ul>
                </li>

                {{-- <li>Gulp</li> --}}
                <li>Git</li>
                <li>Linux shell</li>
                {{-- <li>Linux terminal (Linux Command line)</li> --}}
            </ul>

            <div class="section"><strong>PERSONAL SKILLS</strong></div>

            <ul>
                <li>Flexible</li>
                <li>Multi tasking</li>
                <li>Adaptive to change</li>
                <li>Tech and code news nerd</li>
                {{-- <li>Enthusiastic about web development</li> --}}
                {{-- <li>Willing to learn new skills every day</li> --}}
            </ul>

            <div class="section"><strong>EDUCATION</strong></div>

            <ul>
                <li>2018 - Web Analytics @ Mb web, Milan, Italy</li>
                <li>2014 - HTML/CSS course @ CdS Bologna, Bologna, Italy</li>
                {{-- <li>2010 - Computer Science course @ High School Aldini Valeriani Sirani, Bologna, Italy</li> --}}
            </ul>

            <div class="section"><strong>INTERESTS</strong></div>

            <ul>
                <li>Synthwave enthusiast</li>
                <li>Desktop PC builder</li>
            </ul>

            <div class="section"><strong>LANGUAGES</strong></div>

            <ul>
                <li>Italian - mother tongue</li>
                <li>English - fluent</li>
            </ul>

        </div>
    </div>

</div>
