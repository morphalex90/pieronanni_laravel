import { Link } from '@inertiajs/react'
import { m } from 'framer-motion'
import { Meta } from '@/components/meta'
import { Layout } from '@/layouts/layout'
import { about, home, projects } from '@/routes'

export default function Homepage() {
    return (
        <Layout className="homepage">
            <Meta
                title="Laravel & React Developer in London"
                description="Piero Nanni is a full-stack Laravel and React developer based in London with over ten years of experience. Explore my projects, career and get in touch."
                url={home().url}
            />

            <section className="section --centered">
                <m.h1 initial={{ x: -50, opacity: 0 }} animate={{ x: 0, opacity: 1 }} transition={{ duration: 0.3, delay: 0.2 }}>
                    {/* Reads as "<PieroNanni/>" but the text is the real name, so search engines and screen readers get "Piero Nanni". */}
                    <span aria-hidden="true">{'<'}</span>
                    Piero<span className="sr-only"> </span>Nanni
                    <span aria-hidden="true">{'/>'}</span>
                </m.h1>

                <m.h2
                    initial={{ x: 50, opacity: 0 }}
                    animate={{ x: 0, opacity: 1 }}
                    transition={{ duration: 0.3, delay: 0.2 }}
                    className="homepage__subtitle text-center"
                >
                    Full-stack Laravel &amp; React developer based in London
                </m.h2>

                <m.p
                    initial={{ y: 50, opacity: 0 }}
                    animate={{ y: 0, opacity: 1 }}
                    transition={{ duration: 0.3, delay: 0.2 }}
                    className="homepage__intro text-center"
                >
                    I build websites and web applications with Laravel, React, WordPress and Drupal, and have done so for over ten years in Bologna
                    and London. Today I work as a backend developer at CACI (formerly Cyber-Duck) on large Laravel platforms such as Worcester Bosch.
                    Before that I built a music streaming service with Laravel and React at Soundpickr, and delivered sites for clients like Brompton
                    and Stephenson Harwood at the London agency Purr. See my <Link href={projects().url}>projects</Link> or read more{' '}
                    <Link href={about().url}>about me</Link>.
                </m.p>

                <m.div
                    initial={{ y: 50, opacity: 0 }}
                    animate={{ y: 0, opacity: 1 }}
                    transition={{ duration: 0.3, delay: 0.2 }}
                    className="text-center"
                >
                    <Link href={about().url} className="button --hover-big" title="Explore more!">
                        Explore more!
                    </Link>
                </m.div>
            </section>
        </Layout>
    )
}
