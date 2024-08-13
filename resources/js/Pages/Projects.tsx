import { Head } from '@inertiajs/react';
import Layout from '@/Layouts/Layout'
import { useState } from 'react';
import Project from '@/Components/Project'
import Icon from '@/Components/Icon';

export default function Projects({ technologies, allJobs }: { technologies: any[], allJobs: any[] }) {
    const [jobs, setJobs] = useState<any[]>(allJobs);
    const [activeTechnology, setActiveTechnology] = useState<any>('*');

    function filterProjects(techKey: any) {
        setActiveTechnology(techKey)

        if (techKey === '*') { // if it's 'All', re load all
            setJobs(allJobs);
        } else { // filter by tech key
            const reducedJobs = allJobs.reduce((result: any, job: any) => {
                const filteredProjects = job.projects.filter((project: any) =>
                    project.technologies.some((tech: any) => tech.key === techKey)
                );

                if (filteredProjects.length > 0) {
                    result.push({ ...job, projects: filteredProjects });
                }

                return result;
            }, []);

            setJobs(reducedJobs)
        }
    }

    return (
        <>
            <Head>
                {/* <link rel="canonical" href={process.env.NEXT_PUBLIC_APP_URL + '/projects'} /> */}
                <title>Projects</title>
                <meta name="description" content="Check out the complete list of websites created by Piero Nanni during his career" />

                <meta property="og:type" content="profile" />
                <meta property="og:title" content="Projects | Piero Nanni" />
                <meta property="og:description" content="Check out the complete list of websites created by Piero Nanni during his career" />
                <meta property="og:image" content="" />
                {/* <meta property="og:url" content={process.env.NEXT_PUBLIC_APP_URL + '/projects'} /> */}
            </Head>

            <Layout className="page-projects">
                <h1>Projects</h1>

                {technologies.length > 0 &&
                    <div className="technologies">
                        {technologies.map((tech, id) =>
                            <div key={id} className={'technologies__single' + (activeTechnology === tech.key ? ' is-active' : '')} onClick={e => filterProjects(tech.key)}>
                                {tech.key !== '*' &&
                                    <Icon technology={tech.key} />
                                }
                                <span>{tech.name}</span>
                            </div>
                        )}
                    </div>
                }

                {jobs?.length > 0 &&
                    (jobs.map(job =>
                        <div key={job.id} className="jobs">
                            {job.projects?.length > 0 &&
                                <>
                                    <h3 className="text-center"><a href={job.company.url} target="_blank" rel="noreferrer">{job.company.name}</a></h3>

                                    <div className="projects">
                                        {job.projects?.map((project: any, projectId: any) =>
                                            <Project key={projectId} project={project} delay={(projectId + 1) / 12} />
                                        )}
                                    </div>
                                </>
                            }
                        </div>
                    ))
                }
            </Layout>
        </>
    );
}
