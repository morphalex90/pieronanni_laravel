import { Head } from '@inertiajs/react'
import { APP_URL } from '@/lib/config'

export function Meta({
    url = '',
    title,
    description,
    image = APP_URL + '/img/background.webp',
    type = 'profile',
    noIndex,
}: {
    url?: string
    title: string
    description: string
    image?: string
    type?: string
    noIndex?: boolean
}) {
    // Structured data for SEO
    const structuredData = {
        '@context': 'https://schema.org',
        '@type': 'WebPage',
        name: title,
        description: description,
        url: url,
    }

    return (
        <Head>
            <link rel="canonical" href={APP_URL + url} />
            <title>{`${title}`}</title>
            <meta name="description" content={description} />
            <meta property="og:url" content={APP_URL + url} />
            <meta property="og:type" content={type} />
            <meta property="og:title" content={title} />
            <meta property="og:description" content={description} />
            <meta property="og:image" content={image} />

            <meta name="twitter:card" content="summary" />
            <meta property="twitter:title" content={title} />
            <meta property="twitter:description" content={description} />
            <meta property="twitter:image" content={image} />

            {noIndex && <meta name="robots" content="noindex" />}

            <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(structuredData) }} />
        </Head>
    )
}
