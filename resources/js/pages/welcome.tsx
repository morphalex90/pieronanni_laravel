import { Link } from '@inertiajs/react'
import { motion } from 'framer-motion'
import { Meta } from '@/components/meta'
import { Layout } from '@/layouts/layout'
import { about, home } from '@/routes'

export default function Homepage() {
    return (
        <Layout className="homepage">
            <Meta
                title="Full-Stack Developer, London | Laravel & React"
                description="Piero Nanni is a full-stack web developer based in London, specialising in Laravel and React. Explore my projects, skills, and get in touch."
                url={home().url}
            />

            <section className="section --centered">
                <motion.h1 initial={{ x: -50, opacity: 0 }} animate={{ x: 0, opacity: 1 }} transition={{ duration: 0.3, delay: 0.2 }} aria-label="Piero Nanni, Full-Stack Developer specialising in Laravel and React">
                    {'<PieroNanni/>'}
                </motion.h1>

                <motion.h2
                    initial={{ x: 50, opacity: 0 }}
                    animate={{ x: 0, opacity: 1 }}
                    transition={{ duration: 0.3, delay: 0.2 }}
                    className="text-center"
                    style={{ marginBottom: 20 }}
                >
                    Full-stack Developer based in London
                </motion.h2>

                <motion.div
                    initial={{ y: 50, opacity: 0 }}
                    animate={{ y: 0, opacity: 1 }}
                    transition={{ duration: 0.3, delay: 0.2 }}
                    className="text-center"
                >
                    <Link href={about().url} className="button --hover-big" title="Explore more!">
                        Explore more!
                    </Link>
                </motion.div>
            </section>
        </Layout>
    )
}
