import { useState, useCallback, useMemo } from 'react'
import Icon from '@/components/icon'
import { Meta } from '@/components/meta'
import Project from '@/components/project'
import Layout from '@/layouts/layout'
import { projects } from '@/routes'
import { type JobType, type ProjectType, type TechnologyType } from '@/types'

import '../../css/_modal.scss'
import '../../css/_projects.scss'
import '../../css/_technologies.scss'

const filterJobsByTechnology = (allJobs: JobType[], techKey: string): JobType[] => {
    if (techKey === '*') {
        return allJobs
    }

    return allJobs.reduce((result: JobType[], job: JobType) => {
        const filteredProjects = job.projects.filter((project: ProjectType) =>
            project.technologies.some((tech: TechnologyType) => tech.key === techKey),
        )

        if (filteredProjects.length > 0) {
            result.push({ ...job, projects: filteredProjects })
        }

        return result
    }, [])
}

export default function Projects({ technologies, allJobs }: { technologies: TechnologyType[]; allJobs: JobType[] }) {
    const [activeTechnology, setActiveTechnology] = useState<string>('*')

    const jobs = useMemo(
        () => filterJobsByTechnology(allJobs, activeTechnology),
        [allJobs, activeTechnology],
    )

    const handleTechnologyFilter = useCallback((techKey: string) => {
        setActiveTechnology(techKey)
    }, [])

    return (
        <Layout className="page-projects">
            <Meta
                url={projects().url}
                description="Check out the complete list of websites created by Piero Nanni during his career"
                title="Projects"
            />

            <h1>Projects</h1>

            {technologies.length > 0 && (
                <div className="technologies">
                    {technologies.map((tech) => (
                        <div
                            key={tech.key}
                            className={'technologies__single' + (activeTechnology === tech.key ? ' is-active' : '')}
                            onClick={() => handleTechnologyFilter(tech.key)}
                        >
                            {tech.key !== '*' && <Icon technology={tech.key} />}
                            <span>{tech.name}</span>
                        </div>
                    ))}
                </div>
            )}

            {jobs.length > 0 &&
                jobs.map((job) => (
                    <div key={job.id} className="jobs">
                        {job.projects.length > 0 && (
                            <>
                                <h3 className="text-center">
                                    <a href={job.company.url} target="_blank" rel="noreferrer">
                                        {job.company.name}
                                    </a>
                                </h3>

                                <div className="projects">
                                    {job.projects.map((project: ProjectType, projectId: number) => (
                                        <Project key={`${job.id}-${projectId}`} project={project} delay={(projectId + 1) / 12} />
                                    ))}
                                </div>
                            </>
                        )}
                    </div>
                ))}
        </Layout>
    )
}
