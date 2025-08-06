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

    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
        <section class="bg-white shadow-sm">
            <div class="max-w-6xl mx-auto px-6 py-16">
                <div class="text-center">
                    <h1 class="text-5xl font-bold text-gray-900 mb-4">Piero Nanni</h1>
                    <p class="text-2xl text-gray-600 mb-8">Full-stack Developer</p>

                    <div class="flex flex-wrap justify-center gap-6 text-gray-600 mb-8">
                        <div class="flex items-center gap-2">
                            <x-lucide-pin class="w-5 h-5" />
                            <span>London, UK</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-lucide-calendar class="h-5 w-5 text-gray-500" />
                            <span>+44 7724 146851</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-lucide-mail class="w-5 h-5" />
                            <span>piero.nanni@gmail.com</span>
                        </div>
                    </div>

                    <div class="flex justify-center gap-4">
                        <Button variant="default" class="flex items-center gap-2">
                            <x-lucide-globe class="w-4 h-4" />
                            www.pieronanni.me
                        </Button>
                        <Button variant="outline" class="flex items-center gap-2">
                            <x-lucide-github class="w-4 h-4" />
                            GitHub Profile
                        </Button>
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-6xl mx-auto px-6 py-12">
            <section class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Work Experience</h2>
                <div class="space-y-8">
                    <!-- {experiences.map((exp, index) => ( -->
                    <Card key={index} class="shadow-md">
                        <CardHeader>
                            <div class="flex justify-between items-start">
                                <div>
                                    <CardTitle class="text-xl">{exp.title}</CardTitle>
                                    <CardDescription class="text-lg font-medium text-gray-700">
                                        {exp.company}
                                    </CardDescription>
                                </div>
                                <div class="text-right text-sm text-gray-500">
                                    <div class="flex items-center gap-1 mb-1">
                                        <x-lucide-pin class="w-4 h-4" />
                                        {exp.location}
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <x-lucide-calendar class="w-4 h-4" />
                                        {exp.period}
                                    </div>
                                </div>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Key Achievements:</h4>
                                    <ul class="list-disc list-inside space-y-1 text-gray-700">
                                        <!-- {exp.achievements.map((achievement, i) => ( -->
                                        <li key={i}>{achievement}</li>
                                        <!-- ))} -->
                                    </ul>
                                </div>
                                <!-- {exp.projects.length > 0 && ( -->
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Notable Projects:</h4>
                                    <ul class="list-disc list-inside space-y-1 text-gray-700">
                                        <!-- {exp.projects.map((project, i) => ( -->
                                        <li key={i}>{project}</li>
                                        <!-- ))} -->
                                    </ul>
                                </div>
                                <!-- )} -->
                            </div>
                        </CardContent>
                    </Card>
                    <!-- ))} -->
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

            <section class="text-center">
                <Card class="shadow-lg bg-gradient-to-r from-blue-50 to-indigo-50">
                    <CardHeader>
                        <CardTitle class="text-2xl">Let's Work Together</CardTitle>
                        <CardDescription class="text-lg">
                            Ready to bring your next project to life? Get in touch!
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="flex flex-wrap justify-center gap-4">
                            <Button size="lg" class="flex items-center gap-2">
                                <x-lucide-mail class="w-5 h-5" />
                                Send Email
                            </Button>
                            <Button variant="outline" size="lg" class="flex items-center gap-2">
                                <Phone class="w-5 h-5" />
                                Call Me
                            </Button>
                            <Button variant="outline" size="lg" class="flex items-center gap-2">
                                <x-lucide-globe class="w-5 h-5" />
                                Visit Website
                            </Button>
                        </div>
                    </CardContent>
                </Card>
            </section>
        </div>
    </div>
</body>

</html>