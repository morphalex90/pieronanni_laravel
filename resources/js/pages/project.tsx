import { Link } from '@inertiajs/react'
import Markdown from 'react-markdown'
import Icon from '@/components/icon'
import { Meta, PERSON_ID } from '@/components/meta'
import { Layout } from '@/layouts/layout'
import { APP_URL } from '@/lib/config'
import { contact, home, projects } from '@/routes'
import { show } from '@/routes/projects'
import type { ProjectType } from '@/types'

import '../../css/_project.scss'

export default function Project({ project, isIndexable }: { project: ProjectType; isIndexable: boolean }) {
    const url = show(project).url
    const technologyNames = project.technologies.map((technology) => technology.name)
    const companyName = project.job?.company.name
    const year = project.published_at.substring(0, 4)
    const title = `${project.title}: ${technologyNames.length > 0 ? technologyNames.slice(0, 2).join(' & ') : 'web'} project`
    const description = project.description_cv
        ? `${project.title}, built by Piero Nanni: ${project.description_cv}`
        : `${project.title}, a web project built by Piero Nanni.`

    return (
        <Layout className="page-project">
            <Meta
                url={url}
                title={title}
                description={description.length > 160 ? description.substring(0, 157).trimEnd() + '...' : description}
                image={project.media?.[0]?.thumbnail_url}
                noIndex={!isIndexable}
                breadcrumbs={[
                    { name: 'Home', url: home().url },
                    { name: 'Projects', url: projects().url },
                    { name: project.title, url },
                ]}
                entities={[
                    {
                        '@type': 'CreativeWork',
                        '@id': APP_URL + url + '#project',
                        name: project.title,
                        url: APP_URL + url,
                        ...(project.description_cv ? { abstract: project.description_cv } : {}),
                        dateCreated: project.published_at,
                        creator: { '@id': PERSON_ID },
                        keywords: technologyNames,
                        ...(project.media?.[0] ? { image: project.media[0].thumbnail_url } : {}),
                        ...(project.url ? { sameAs: project.url } : {}),
                    },
                ]}
            />

            <article className="project-page">
                <nav aria-label="Breadcrumb" className="project-page__breadcrumb">
                    <Link href={projects().url}>Projects</Link> / <span aria-current="page">{project.title}</span>
                </nav>

                <h1>{project.title}</h1>

                <p className="project-page__meta">
                    {companyName ? `${companyName}, ` : ''}
                    {year}
                </p>

                {project.technologies.length > 0 && (
                    <ul className="project-page__tech" aria-label="Technologies">
                        {project.technologies.map((technology) => (
                            <li key={technology.id}>
                                <Icon technology={technology.key} />
                                <span>{technology.name}</span>
                            </li>
                        ))}
                    </ul>
                )}

                <div className="d-flex --reverse">
                    <div className="project-page__content">
                        <Markdown>{project.description}</Markdown>

                        <div className="project-page__actions">
                            {project.url && (
                                <a href={project.url} className="button" target="_blank" rel="noreferrer">
                                    Visit site
                                </a>
                            )}
                            {project.github && (
                                <a href={project.github} className="button" target="_blank" rel="noreferrer">
                                    GitHub
                                </a>
                            )}
                        </div>

                        <p>
                            Need something similar built in Laravel or React? <Link href={contact().url}>Get in touch</Link> or browse{' '}
                            <Link href={projects().url}>more projects</Link>.
                        </p>
                    </div>

                    {project.media && project.media.length > 0 && (
                        <div className="project-page__images">
                            {project.media.map((image, index) => (
                                <img
                                    key={image.id}
                                    src={image.url}
                                    alt={`${project.title} screenshot ${index + 1}`}
                                    loading={index === 0 ? 'eager' : 'lazy'}
                                />
                            ))}
                        </div>
                    )}
                </div>
            </article>
        </Layout>
    )
}
