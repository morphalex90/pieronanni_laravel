import { m } from 'framer-motion'
import { type MouseEvent, useState } from 'react'

import placeholder from '@/../img/placeholder.svg'
import Icon from '@/components/icon'
import Modal from '@/components/modal'
import { show } from '@/routes/projects'
import type { ProjectType, TechnologyType } from '@/types'

export default function Project({ project, delay, isAboveFold = false }: { project: ProjectType; delay: number; isAboveFold?: boolean }) {
    const [modalShow, setModalShow] = useState(false)
    const [modalContent, setModalContent] = useState<ProjectType>({
        id: 1,
        title: '',
        slug: '',
        url: '',
        published_at: '',
        github: '',
        technologies: [],
    })

    return (
        <>
            {/* A real link so crawlers and new-tab clicks reach the project page; a plain click opens the modal instead. */}
            <m.a
                href={show(project).url}
                className="projects__single"
                initial={{ y: 10, opacity: 0 }}
                animate={{ y: 0, opacity: 1 }}
                transition={{ duration: 0.3, delay }}
                onClick={(event: MouseEvent<HTMLAnchorElement>) => {
                    if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
                        return
                    }

                    event.preventDefault()
                    setModalShow(true)
                    setModalContent(project)
                }}
                aria-label={'View project details for ' + project.title}
                aria-haspopup="dialog"
                aria-expanded={modalShow}
            >
                <span className="projects__single__image">
                    <img
                        src={project?.media?.[0] ? project.media[0].thumbnail_url : placeholder}
                        alt={project.title}
                        title={project.title}
                        width={333}
                        height={200}
                        loading={isAboveFold ? 'eager' : 'lazy'}
                        fetchPriority={isAboveFold ? 'high' : undefined}
                    />
                </span>

                <span className="projects__single__content">
                    <span className="projects__single__title">{project.title}</span>
                    <span className="projects__single__tech">
                        {project?.technologies?.map((tech: TechnologyType) => {
                            return <Icon key={tech.id} technology={tech.key} />
                        })}
                    </span>
                </span>
            </m.a>

            <Modal onClose={() => setModalShow(false)} show={modalShow} content={modalContent} />
        </>
    )
}
