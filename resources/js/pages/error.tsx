import Layout from '@/layouts/layout'
import { Head } from '@inertiajs/react'

export default function ErrorPage({ status }: { status: number }) {
    const title = {
        503: '503: Service Unavailable',
        500: '500: Server Error',
        404: '404: Page Not Found',
        403: '403: Forbidden',
    }[status]

    const description = {
        503: 'Sorry, we are doing some maintenance. Please check back soon.',
        500: 'Whoops, something went wrong on our servers.',
        404: 'Sorry, the page you are looking for could not be found.',
        403: 'Sorry, you are forbidden from accessing this page.',
    }[status]

    return (
        <>
            <Head>
                <title>{title}</title>
                <meta name="description" content={description} />
                <meta property="og:title" content={title + ' | Piero Nanni'} />
                <meta property="og:description" content={description} />
            </Head>

            <Layout className="error">
                <section className="section --centered">
                    <h1>{title}</h1>
                    <h2>{description}</h2>
                </section>
            </Layout>
        </>
    )
}
