import { Link } from '@inertiajs/react'
import { Meta, PERSON_ID } from '@/components/meta'
import { Layout } from '@/layouts/layout'
import { APP_URL } from '@/lib/config'
import { about, contact, freelance, home, projects } from '@/routes'
import { show } from '@/routes/projects'

import '../../css/_freelance.scss'

const SERVICES = [
    {
        title: 'Laravel applications and APIs',
        body: 'New Laravel builds, REST APIs and admin panels, or new features on an existing codebase. At Soundpickr I architected the full Laravel API that every front-end connected to, and at CACI I work on large Laravel platforms every day.',
    },
    {
        title: 'React and Next.js front-ends',
        body: 'Fast, maintainable interfaces in React, Next.js or Inertia, wired to a Laravel back-end. I built several Next.js and Vite front-ends on top of the Soundpickr API.',
    },
    {
        title: 'Performance and technical SEO',
        body: 'Audits and fixes for slow pages and poor Core Web Vitals. At CACI I doubled page speed and halved bandwidth on high-traffic e-commerce sites, and at Soundpickr SEO and performance work drove 50% user growth in two months.',
    },
    {
        title: 'WordPress and Drupal sites',
        body: 'Fully editable WordPress sites with custom Gutenberg blocks, and Drupal multisites where new sites can be launched from the CMS. I led WordPress and Drupal projects at the London agency Purr.',
    },
    {
        title: 'Migrations and modernisation',
        body: 'Moving sites to new hosting or AWS, and bringing older codebases up to date with Composer, CI/CD pipelines and current framework versions.',
    },
]

const CASE_STUDIES = [
    {
        slug: 'soundpickr',
        title: 'Soundpickr',
        stack: 'Laravel, Next.js, AWS S3',
        body: 'Music platform built from the ground up as founding engineer: a Laravel API synced with Spotify for around 7 million artists, an audio upload pipeline to S3, and 50% user growth in two months.',
    },
    {
        slug: 'worcester-bosch',
        title: 'Worcester Bosch',
        stack: 'Laravel, React',
        body: 'Ongoing backend development at CACI on the Laravel platform of the UK heating and hot water manufacturer.',
    },
    {
        slug: 'stephenson-harwood',
        title: 'Stephenson Harwood',
        stack: 'Drupal',
        body: 'A customisable Drupal multisite for the international law firm, letting editors launch a new branded site straight from the CMS.',
    },
    {
        slug: 'brompton',
        title: 'Brompton',
        stack: 'WordPress',
        body: 'A fully editable, fast-loading WordPress site for the bike maker, built on custom Gutenberg blocks instead of a page builder.',
    },
]

const STEPS = [
    { title: 'Brief', body: 'You tell me what you need to build or fix, your goals and your timeline.' },
    { title: 'Scope', body: 'I suggest an approach and stack, and agree the scope and an estimate with you.' },
    { title: 'Build', body: 'I work in small iterations, sharing progress regularly so you can give feedback early.' },
    { title: 'Launch and support', body: 'I help you deploy, then stay available for fixes and further improvements.' },
]

export default function Freelance() {
    const url = freelance().url

    return (
        <Layout className="page-freelance">
            <Meta
                url={url}
                title="Freelance Laravel Developer in London"
                description="Freelance Laravel and React developer in London with over ten years of experience: Laravel apps and APIs, React front-ends, performance and SEO, WordPress and Drupal."
                breadcrumbs={[
                    { name: 'Home', url: home().url },
                    { name: 'Freelance', url },
                ]}
                entities={[
                    {
                        '@type': 'Service',
                        '@id': APP_URL + url + '#service',
                        name: 'Freelance Laravel & React development',
                        serviceType: SERVICES.map((service) => service.title),
                        provider: { '@id': PERSON_ID },
                        areaServed: [
                            { '@type': 'City', name: 'London' },
                            { '@type': 'Country', name: 'United Kingdom' },
                        ],
                        url: APP_URL + url,
                    },
                ]}
            />

            <article className="freelance">
                <h1 className="text-center">Freelance Laravel &amp; React developer in London</h1>

                <p className="freelance__lead text-center">
                    I&#39;m Piero Nanni, a full-stack developer who has been building websites and web applications for over ten years in Bologna and
                    London. I take on freelance Laravel and React work for startups, agencies and businesses, whether that&#39;s a new build,
                    improving an existing codebase, or an extra pair of hands on your team.
                </p>

                <p className="text-center">
                    <Link href={contact().url} className="button">
                        Tell me about your project
                    </Link>
                </p>

                <section>
                    <h2>What I can help with</h2>
                    <div className="freelance__grid">
                        {SERVICES.map((service) => (
                            <div key={service.title} className="freelance__card">
                                <h3>{service.title}</h3>
                                <p>{service.body}</p>
                            </div>
                        ))}
                    </div>
                </section>

                <section>
                    <h2>Selected work</h2>
                    <div className="freelance__grid">
                        {CASE_STUDIES.map((study) => (
                            <div key={study.slug} className="freelance__card">
                                <h3>
                                    <Link href={show(study.slug).url}>{study.title}</Link>
                                </h3>
                                <p className="freelance__stack">{study.stack}</p>
                                <p>{study.body}</p>
                            </div>
                        ))}
                    </div>
                    <p>
                        See all <Link href={projects().url}>30+ projects</Link> or my full <Link href={about().url}>career history</Link>.
                    </p>
                </section>

                <section>
                    <h2>How I work</h2>
                    <ol className="freelance__steps">
                        {STEPS.map((step) => (
                            <li key={step.title}>
                                <strong>{step.title}.</strong> {step.body}
                            </li>
                        ))}
                    </ol>
                </section>

                <section className="text-center">
                    <h2>Start a project</h2>
                    <p>Send me a short description of what you need, and when, and I&#39;ll get back to you.</p>
                    <p>
                        <Link href={contact().url} className="button">
                            Get in touch
                        </Link>
                    </p>
                </section>
            </article>
        </Layout>
    )
}
