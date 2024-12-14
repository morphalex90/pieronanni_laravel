import Icon from '@/Components/Icon'
import Project from '@/Components/Project'
import Layout from '@/Layouts/Layout'
import { JobType, ProjectType, TechnologyType } from '@/types'
import { Head } from '@inertiajs/react'
import { useState } from 'react'

import '../../css/_modal.scss'
import '../../css/_projects.scss'
import '../../css/_technologies.scss'

export default function Projects({ technologies, allJobs }: { technologies: TechnologyType[]; allJobs: JobType[] }) {
    const [jobs, setJobs] = useState(allJobs)
    const [activeTechnology, setActiveTechnology] = useState<string>('*')

    function filterProjects(techKey: string) {
        setActiveTechnology(techKey)

        if (techKey === '*') {
            // if it's 'All', re load all
            setJobs(allJobs)
        } else {
            // filter by tech key
            const reducedJobs = allJobs.reduce((result: JobType[], job: JobType) => {
                const filteredProjects = job.projects.filter((project: ProjectType) => project.technologies.some((tech: TechnologyType) => tech.key === techKey))

                if (filteredProjects.length > 0) {
                    result.push({ ...job, projects: filteredProjects })
                }

                return result
            }, [])

            setJobs(reducedJobs)
        }
    }

    return (
        <>
            <Head>
                <link rel="canonical" href={route('projects')} />
                <title>Projects</title>
                <meta name="description" content="Check out the complete list of websites created by Piero Nanni during his career" />

                <meta property="og:type" content="profile" />
                <meta property="og:title" content="Projects | Piero Nanni" />
                <meta property="og:description" content="Check out the complete list of websites created by Piero Nanni during his career" />
                {/* <meta property="og:image" content="" /> */}
                <meta property="og:url" content={route('projects')} />
            </Head>

            <Layout className="page-projects">
                <h1>Projects</h1>

                {technologies.length > 0 && (
                    <div className="technologies">
                        {technologies.map((tech, id) => (
                            <div key={id} className={'technologies__single' + (activeTechnology === tech.key ? ' is-active' : '')} onClick={() => filterProjects(tech.key)}>
                                {tech.key !== '*' && <Icon technology={tech.key} />}
                                <span>{tech.name}</span>
                            </div>
                        ))}
                    </div>
                )}

                {jobs?.length > 0 &&
                    jobs.map((job) => (
                        <div key={job.id} className="jobs">
                            {job.projects?.length > 0 && (
                                <>
                                    <h3 className="text-center">
                                        <a href={job.company.url} target="_blank" rel="noreferrer">
                                            {job.company.name}
                                        </a>
                                    </h3>

                                    <div className="projects">{job.projects?.map((project: ProjectType, projectId: number) => <Project key={projectId} project={project} delay={(projectId + 1) / 12} />)}</div>
                                </>
                            )}
                        </div>
                    ))}
            </Layout>
        </>
    )
}
