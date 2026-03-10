<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    <title>CV Piero Nanni</title>

    <style>
        :root {
            --accent: #1A5276;
            --accent-light: #AED6F1;
            --accent-bg: #EAF2F8;
            --mid-gray: #555555;
            --dark: #1C1C1C;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Lato', sans-serif;
            background: #f0f4f8;
            color: var(--dark);
        }

        h1 {
            font-family: 'Playfair Display', serif;
        }

        @media print {
            body {
                background: white;
            }

            .no-print {
                display: none;
            }

            .page {
                box-shadow: none;
                margin: 0;
                border-radius: 0;
            }
        }

        .section-title::after {
            content: '';
            display: block;
            height: 2px;
            background: var(--accent-light);
            margin-top: 6px;
            width: 100%;
        }

        .skill-chip {
            transition: background 0.2s, color 0.2s, transform 0.15s;
        }

        .skill-chip:hover {
            background: var(--accent);
            color: white;
            transform: translateY(-1px);
        }

        .project-item {
            border-left: 3px solid var(--accent-light);
            transition: border-color 0.2s;
        }

        .project-item:hover {
            border-left-color: var(--accent);
        }

        .tech-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .tech-icon img {
            width: 13px;
            height: 13px;
            object-fit: contain;
            opacity: 0.65;
        }
    </style>
</head>

<body class="p-0">
    <div class="page max-w-[900px] mx-auto bg-white shadow-2xl rounded-sm overflow-hidden">

        <header
            class="bg-[#1A5276] flex flex-col sm:flex-row justify-between items-start sm:items-center px-8 py-6 gap-6">
            <div>
                <h1 class="text-5xl text-white tracking-tight leading-tight">Piero Nanni</h1>
                <p class="mt-2 text-[#BFD9F0] text-base font-light tracking-wide">Full-Stack Developer · Laravel &amp;
                    React Specialist</p>
            </div>
            <div class="text-right text-sm text-white/90 font-light space-y-1.5 shrink-0">
                <div class="flex items-center justify-end gap-2"><span>📍</span><span>London, UK</span></div>
                <div class="flex items-center justify-end gap-2"><span>🌐</span><a href="https://pieronanni.me"
                        target="_blank" class="hover:underline">pieronanni.me</a></div>
                <div class="flex items-center justify-end gap-2"><span>📞</span><span>+44 7724 146851</span></div>
                <div class="flex items-center justify-end gap-2"><span>📧</span><a href="mailto:piero.nanni@gmail.com"
                        class="hover:underline">piero.nanni@gmail.com</a></div>


                <div class="flex items-center justify-end gap-2"><span>💻</span><a href="https://github.com/morphalex90"
                        target="_blank" class="hover:underline">github.com/morphalex90</a></div>
            </div>
        </header>

        <main class="px-10 py-8 space-y-8">

            <section>
                <h2 class="section-title text-[#1A5276] text-xs font-bold uppercase tracking-[0.15em]">Professional
                    Summary</h2>
                <p class="mt-3 text-sm text-[#1C1C1C] leading-relaxed font-light">
                    Full-stack developer with 10 years of experience building and optimising web applications,
                    specialising in Laravel, React, and modern web application architecture.
                    Comfortable owning projects end-to-end, from API design to front-end implementation and DevOps
                    deployment.
                </p>
            </section>

            <section>
                <h2 class="section-title text-[#1A5276] text-xs font-bold uppercase tracking-[0.15em]">Work Experience
                </h2>
                <div class="mt-4 space-y-7">

                    @foreach ($jobs as $job)
                        <div>
                            <div class="flex flex-wrap justify-between items-baseline gap-1">
                                <div class="flex items-baseline gap-2 flex-wrap">
                                    <span class="font-bold text-base text-[#1C1C1C]">{{ $job->title }}</span>
                                    <span class="text-[#cccccc] text-sm">|</span>
                                    <span class="font-bold text-sm text-[#1A5276]"><a href="{{ $job->company['url'] }}"
                                            target="_blank">{{ $job->company['name'] }}</a></span>
                                </div>
                                <span
                                    class="text-xs text-[#555555] italic">{{ Carbon\Carbon::parse($job->started_at)->format('F Y') }}
                                    @if ($job->ended_at)
                                        - {{ Carbon\Carbon::parse($job->ended_at)->format('F Y') }} ({{ $job->duration }})
                                    @else
                                        - Present
                                    @endif
                                </span>
                            </div>
                            <div class="text-xs text-[#888888] mt-0.5 mb-2">📍 {{ $job->location }}</div>
                            {!! parseMarkdownWithClasses($job->description_cv) !!}
                            <div class="mt-3">
                                <p class="text-xs font-bold text-[#555555] uppercase tracking-wider mb-2">Key Projects</p>
                                <div class="space-y-1.5">
                                    @foreach ($job->projects as $project)
                                        @if($project->is_visible_in_cv)
                                            <div class="project-item pl-3 py-0.5 flex items-start gap-2">
                                                <div class="flex items-center gap-1 mt-0.5 shrink-0">
                                                    @if (count($project->technologies) > 0)
                                                        @foreach ($project->technologies as $tech)
                                                            <span class="tech-icon"><img
                                                                    src="https://cdn.simpleicons.org/{{ $tech->key }}/1A5276"
                                                                    alt="{{ $tech->name }}" title="{{ $tech->name }}" /></span>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="text-sm font-bold text-[#1A5276]">
                                                        <a href="{{ $project->url }}" target="_blank">{{ $project->title }}</a>
                                                    </span>
                                                    <span class="text-sm text-[#555555] font-light"> -
                                                        {{ $project->description_cv }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section>
                <h2 class="section-title text-[#1A5276] text-xs font-bold uppercase tracking-[0.15em]">Technical Skills
                </h2>
                <div class="mt-4 space-y-4">
                    <div>
                        <p class="text-xs font-bold text-[#555555] uppercase tracking-wider mb-2">Languages &amp; Markup
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">PHP</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">JavaScript</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">TypeScript</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">SQL</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">CSS3
                                / Sass</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">BEM</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[#555555] uppercase tracking-wider mb-2">Frameworks &amp;
                            Libraries</p>
                        <div class="flex flex-wrap gap-2">
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">Laravel</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">Next.js</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">React</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">Inertia.js</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">Bootstrap</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">jQuery</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[#555555] uppercase tracking-wider mb-2">CMS &amp; Platforms
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">WordPress
                                Gutenberg Blocks</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">Drupal</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">Magento</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[#555555] uppercase tracking-wider mb-2">Tools &amp; DevOps</p>
                        <div class="flex flex-wrap gap-2">
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">Git</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">Linux
                                / Shell</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">AWS
                                S3</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">CI/CD</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">REST
                                APIs</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">Docker</span>
                            <span
                                class="skill-chip bg-[#EAF2F8] text-[#1A5276] text-xs font-semibold px-3 py-1.5 rounded">Testing
                                (Pest)</span>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="section-title text-[#1A5276] text-xs font-bold uppercase tracking-[0.15em]">Education &amp;
                    Training</h2>
                <div class="mt-3 space-y-2">
                    <div class="flex justify-between items-baseline">
                        <div><span class="text-sm font-bold text-[#1C1C1C]">Web Analytics</span><span
                                class="text-sm text-[#555555] font-light"> · Mb Web, Milan, Italy</span></div>
                        <span class="text-xs text-[#555555] italic">2018</span>
                    </div>
                    <div class="flex justify-between items-baseline">
                        <div><span class="text-sm font-bold text-[#1C1C1C]">HTML / CSS Course</span><span
                                class="text-sm text-[#555555] font-light"> · CdS Bologna, Bologna, Italy</span></div>
                        <span class="text-xs text-[#555555] italic">2014</span>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="section-title text-[#1A5276] text-xs font-bold uppercase tracking-[0.15em]">Languages</h2>
                <div class="mt-3 flex gap-8 text-sm">
                    <div><span class="font-bold text-[#1C1C1C]">Italian</span><span class="text-[#555555] font-light"> —
                            Native</span></div>
                    <div><span class="font-bold text-[#1C1C1C]">English</span><span class="text-[#555555] font-light"> —
                            Fluent (C1+)</span></div>
                </div>
            </section>
        </main>
    </div>
</body>

</html>