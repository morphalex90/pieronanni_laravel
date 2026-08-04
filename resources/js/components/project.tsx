import { m } from 'framer-motion'
import { useState } from 'react'

import placeholder from '@/../img/placeholder.svg'
import Icon from '@/components/icon'
import Modal from '@/components/modal'
import type { ProjectType, TechnologyType } from '@/types'

export default function Project({ project, delay }: { project: ProjectType; delay: number }) {
    const [modalShow, setModalShow] = useState(false)
    const [modalContent, setModalContent] = useState<ProjectType>({
        id: 1,
        title: '',
        url: '',
        published_at: '',
        github: '',
        technologies: [],
    })

    return (
        <>
            <m.button
                type="button"
                className="projects__single"
                initial={{ y: 10, opacity: 0 }}
                animate={{ y: 0, opacity: 1 }}
                transition={{ duration: 0.3, delay }}
                onClick={() => {
                    setModalShow(true)
                    setModalContent(project)
                }}
                aria-label={'View project details for ' + project.title}
                aria-haspopup="dialog"
                aria-expanded={modalShow}
            >
                <span className="projects__single__image">
                    <img
                        src={project?.media?.[0] ? project.media[0].url : placeholder}
                        alt={project.title}
                        title={project.title}
                        width={333}
                        height={200}
                        loading="lazy"
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
            </m.button>

            <Modal onClose={() => setModalShow(false)} show={modalShow} content={modalContent} />
        </>
    )
}
