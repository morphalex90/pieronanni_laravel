import { Link, Head } from '@inertiajs/react';
import { PageProps } from '@/types';
import { motion } from 'framer-motion';
import Layout from '@/Layouts/Layout'

export default function Homepage({ auth }: PageProps<{}>) {

    return (
        <>
            <Head>
                {/* <link rel="canonical" href={process.env.NEXT_PUBLIC_APP_URL} /> */}
                <title>Piero Nanni</title>
                <meta name="description" content="PHP / Js Developer in love with Next.js, London based" />

                <meta property="og:type" content="profile" />
                <meta property="og:title" content="Piero Nanni" />
                <meta property="og:description" content="PHP / Js Developer in love with Next.js, London based" />
                <meta property="og:image" content="" />
                {/* <meta property="og:url" content={process.env.NEXT_PUBLIC_APP_URL} /> */}
            </Head>

            <Layout className="homepage">
                <section className="section --centered">
                    <motion.h1 initial={{ x: -50, opacity: 0 }} animate={{ x: 0, opacity: 1 }} transition={{ duration: 0.3, delay: 0.2 }}>
                        {'<PieroNanni/>'}
                    </motion.h1>

                    <motion.h2 initial={{ x: 50, opacity: 0 }} animate={{ x: 0, opacity: 1 }} transition={{ duration: 0.3, delay: 0.2 }}>
                        Web Developer
                    </motion.h2>
                </section>
            </Layout>
        </>
    );
}
