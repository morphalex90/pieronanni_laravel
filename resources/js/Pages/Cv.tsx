import { Link, Head } from '@inertiajs/react';
import { PageProps } from '@/types';
import { motion } from 'framer-motion';
import Layout from '@/Layouts/Layout'

export default function Cv({ auth }: PageProps<{}>) {

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
                Show CV
            </Layout>
        </>
    );
}
