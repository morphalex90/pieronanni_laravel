import { Head, Link } from '@inertiajs/react'
import { motion } from 'framer-motion'
import Layout from '@/layouts/layout'
import { about, home } from '@/routes'

export default function Homepage() {
    return (
        <>
            <Head>
                <link rel="canonical" href={home().url} />
                <title>Piero Nanni</title>
                <meta name="description" content="PHP / Js Developer in love with Laravel and Next.js, London based" />

                <meta property="og:type" content="profile" />
                <meta property="og:title" content="Piero Nanni" />
                <meta property="og:description" content="PHP / Js Developer in love with Laravel and Next.js, London based" />
                {/* <meta property="og:image" content="" /> */}
                <meta property="og:url" content={home().url} />
            </Head>

            <Layout className="homepage">
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
        </>
    )
}
