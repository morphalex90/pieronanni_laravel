import { Head } from '@inertiajs/react'
import { APP_URL } from '@/lib/config'

export function Meta({
    url = '',
    title,
    description,
    image = APP_URL + '/img/background.webp',
    type = 'website',
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
        '@type': 'Person',
        name: 'Piero Nanni',
        jobTitle: 'Full-Stack Developer',
        url: APP_URL,
        sameAs: [
            'https://github.com/morphalex90',
            'https://www.linkedin.com/in/piero-nanni-87407193'
        ],
        address: {
            '@type': 'PostalAddress',
            addressLocality: 'London'
        },
        worksFor: {
            '@type': 'Organization',
            name: 'CACI',
            url: 'https://www.caci.co.uk/'
        },
        knowsAbout: ['Laravel', 'React', 'PHP', 'Next.js', 'WordPress', 'Drupal', 'AWS'],
        image: image ? image : undefined,
        description,
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

            <meta name="twitter:card" content="summary" />
            <meta property="twitter:title" content={title} />
            <meta property="twitter:description" content={description} />

            {image !== '' && <meta property="og:image" content={image} />}
            {image !== '' && <meta property="twitter:image" content={image} />}

            {noIndex && <meta name="robots" content="noindex" />}

            <script type="application/ld+json">{JSON.stringify(structuredData)}</script>
        </Head>
    )
}
