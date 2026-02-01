import { Link } from '@inertiajs/react'
import { motion } from 'framer-motion'
import { Meta } from '@/components/meta'
import Layout from '@/layouts/layout'
import { about, home } from '@/routes'

export default function Homepage() {
    return (
        <Layout className="homepage">
            <Meta
                url={home().url}
                description="PHP / Js Developer in love with Laravel and Next.js, London based"
                title="Welcome"
            />

            <section className="section --centered">
                <motion.h1 initial={{ x: -50, opacity: 0 }} animate={{ x: 0, opacity: 1 }} transition={{ duration: 0.3, delay: 0.2 }}>
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
