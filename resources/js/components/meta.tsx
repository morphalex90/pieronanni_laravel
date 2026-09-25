import { Head } from '@inertiajs/react'
import { APP_URL } from '@/lib/config'

export type Breadcrumb = {
    name: string
    url: string
}

export const PERSON_ID = APP_URL + '/#person'
const WEBSITE_ID = APP_URL + '/#website'
const EMPLOYER_ID = APP_URL + '/#employer'

// One stable description for the person entity; page-specific copy goes on the WebPage node.
const PERSON_DESCRIPTION =
    'Piero Nanni is a full-stack web developer based in London with over ten years of experience, specialising in Laravel and React.'

export function Meta({
    url = '',
    title,
    description,
    image = APP_URL + '/img/background.webp',
    type = 'website',
    pageType = 'WebPage',
    breadcrumbs = [],
    entities = [],
    noIndex,
}: {
    url?: string
    title: string
    description: string
    image?: string
    type?: string
    pageType?: 'WebPage' | 'AboutPage' | 'ProfilePage' | 'CollectionPage' | 'ContactPage'
    breadcrumbs?: Breadcrumb[]
    entities?: Record<string, unknown>[]
    noIndex?: boolean
}) {
    const canonical = APP_URL + url

    const structuredData = {
        '@context': 'https://schema.org',
        '@graph': [
            {
                '@type': 'Person',
                '@id': PERSON_ID,
                name: 'Piero Nanni',
                jobTitle: 'Full-Stack Developer',
                url: APP_URL + '/',
                description: PERSON_DESCRIPTION,
                sameAs: ['https://github.com/morphalex90', 'https://www.linkedin.com/in/piero-nanni-87407193'],
                address: {
                    '@type': 'PostalAddress',
                    addressLocality: 'London',
                    addressCountry: 'GB',
                },
                worksFor: { '@id': EMPLOYER_ID },
                knowsAbout: ['Laravel', 'React', 'PHP', 'Next.js', 'WordPress', 'Drupal', 'AWS'],
            },
            {
                '@type': 'Organization',
                '@id': EMPLOYER_ID,
                name: 'CACI',
                url: 'https://www.caci.co.uk/',
            },
            {
                '@type': 'WebSite',
                '@id': WEBSITE_ID,
                url: APP_URL + '/',
                name: 'Piero Nanni',
                inLanguage: 'en-GB',
                publisher: { '@id': PERSON_ID },
            },
            {
                '@type': pageType,
                '@id': canonical + '#webpage',
                url: canonical,
                name: title,
                description,
                inLanguage: 'en-GB',
                isPartOf: { '@id': WEBSITE_ID },
                ...(pageType === 'ProfilePage' ? { mainEntity: { '@id': PERSON_ID } } : { about: { '@id': PERSON_ID } }),
                ...(breadcrumbs.length > 0 ? { breadcrumb: { '@id': canonical + '#breadcrumb' } } : {}),
            },
            ...(breadcrumbs.length > 0
                ? [
                      {
                          '@type': 'BreadcrumbList',
                          '@id': canonical + '#breadcrumb',
                          itemListElement: breadcrumbs.map((crumb, index) => ({
                              '@type': 'ListItem',
                              position: index + 1,
                              name: crumb.name,
                              item: APP_URL + crumb.url,
                          })),
                      },
                  ]
                : []),
            ...entities,
        ],
    }

    return (
        <Head>
            <link rel="canonical" href={canonical} />
            <title>{`${title}`}</title>
            <meta name="description" content={description} />
            <meta property="og:url" content={canonical} />
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
