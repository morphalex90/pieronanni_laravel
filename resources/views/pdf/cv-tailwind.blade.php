<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    <title>CV Piero Nanni</title>
</head>

<body>
    <section class="shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-5">
            <div class="text-center">
                <div class="flex gap-3 items-center justify-center mb-4">
                    <h1 class="text-3xl font-bold text-gray-900">Piero Nanni</h1>
                    <p class="text-xl text-gray-600">Full-stack Developer</p>
                </div>

                <div class="flex flex-wrap justify-center gap-x-3 gap-y-2 text-gray-600 mb-5">
                    <div class="flex items-center gap-1">
                        <x-lucide-pin class="w-4 h-4" />
                        <span>London, UK</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <x-lucide-phone class="w-4 h-4" />
                        <span><a href="tel:+447724146851">+44 7724 146851</a></span>
                    </div>
                    <div class="flex items-center gap-1">
                        <x-lucide-mail class="w-4 h-4" />
                        <span><a href="mailto:piero.nanni@gmail.com">piero.nanni@gmail.com</a></span>
                    </div>

                    <Button variant="default" class="flex items-center gap-1">
                        <x-lucide-globe class="w-4 h-4" />
                        <a href="https://www.pieronanni.me">pieronanni.me</a>
                    </Button>
                    <Button variant="outline" class="flex items-center gap-1">
                        <x-lucide-github class="w-4 h-4" />
                        <a href="https://github.com/morphalex90">@morphalex90</a>
                    </Button>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-6 py-12">
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Work Experience</h2>
            <div class="space-y-8">

                @foreach ($jobs as $job)
                    <Card key={index} class="shadow-md">
                        <CardHeader>
                            <div class="flex justify-between items-start">
                                <div>
                                    <CardTitle class="text-xl">{{ $job->title }}</CardTitle>
                                    <CardDescription class="text-lg font-medium text-gray-700">
                                        <a href={{ $job->company['url'] }}>{{ $job->company['name'] }}</a>
                                    </CardDescription>
                                </div>
                                <div class="text-right text-sm text-gray-500">
                                    <div class="flex items-center gap-1 mb-1">
                                        {{-- <x-lucide-pin class="w-4 h-4" /> --}}
                                        {{ $job->location }}
                                    </div>
                                    <div class="flex items-center gap-1">
                                        {{-- <x-lucide-calendar class="w-4 h-4" /> --}}
                                        {{ Carbon\Carbon::parse($job->started_at)->format('F Y') }}

                                        @if ($job->ended_at)
                                            - {{ Carbon\Carbon::parse($job->ended_at)->format('F Y') }}
                                            ({{ $job->duration }})
                                        @else
                                            - Present
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Key Achievements:</h4>
                                    {{-- <ul class="list-disc list-inside space-y-1 text-gray-700"> --}}
                                        <x-markdown>{!! $job->description_cv !!}</x-markdown>
                                        {{--
                                    </ul> --}}
                                </div>
                                <!-- {exp.projects.length > 0 && ( -->
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Notable Projects:</h4>
                                    <ul class="space-y-1 text-gray-700">
                                        @foreach ($job->projects as $project)
                                            @if($project->is_visible_in_cv == true)
                                                <li class="flex gap-2">
                                                    @if (count($project->technologies) > 0)
                                                        @foreach ($project->technologies as $tech)
                                                            <div class="h-4 w-4">
                                                                {!! file_get_contents('svg/' . $tech->key . '.svg') !!}
                                                            </div>
                                                        @endforeach
                                                    @endif

                                                    <div>
                                                        <a href={{ $project->url }}>{{ $project->title }}</a> -
                                                        {{ $project->description_cv }}
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- )} -->
                            </div>
                        </CardContent>
                    </Card>
                @endforeach
            </div>
        </section>

        <section class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Technical Skills</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <Card class="shadow-md">
                    <CardHeader>
                        <CardTitle>Technical Skills</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-4">
                            <!-- {Object.entries(technicalSkills).map(([category, skills]) => ( -->
                            <div key={category}>
                                <h4 class="font-semibold text-gray-900 mb-2">{category}</h4>
                                <div class="flex flex-wrap gap-2">
                                    {skills.map((skill, i) => (
                                    <Badge key={i} variant="secondary">{skill}</Badge>
                                    ))}
                                </div>
                            </div>
                            <!-- ))} -->
                        </div>
                    </CardContent>
                </Card>

                <Card class="shadow-md">
                    <CardHeader>
                        <CardTitle>Personal Skills & Languages</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-2">Personal Skills</h4>
                                <div class="flex flex-wrap gap-2">
                                    <!-- {personalSkills.map((skill, i) => ( -->
                                    <Badge key={i} variant="outline">{skill}</Badge>
                                    <!-- ))} -->
                                </div>
                            </div>
                            <Separator />
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-2">Languages</h4>
                                <div class="space-y-1 text-gray-700">
                                    <div>Italian - Mother tongue</div>
                                    <div>English - Fluent</div>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </section>

        <section class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Education & Interests</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <Card class="shadow-md">
                    <CardHeader>
                        <CardTitle>Education</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-3 text-gray-700">
                            <div>
                                <div class="font-semibold">Web Analytics</div>
                                <div class="text-sm text-gray-600">2018 - Mb web, Milan, Italy</div>
                            </div>
                            <div>
                                <div class="font-semibold">HTML/CSS Course</div>
                                <div class="text-sm text-gray-600">2014 - CdS Bologna, Bologna, Italy</div>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card class="shadow-md">
                    <CardHeader>
                        <CardTitle>Interests</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-2">
                            <Badge variant="secondary">Synthwave enthusiast</Badge>
                            <Badge variant="secondary">Desktop PC builder</Badge>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </section>
    </div>
</body>

</html>