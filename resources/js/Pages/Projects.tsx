import { Link, Head } from '@inertiajs/react';
import { PageProps } from '@/types';
import { motion } from 'framer-motion';
import Layout from '@/Layouts/Layout'
import { useEffect, useState } from 'react';
import { JobList } from '@/components/Data/Jobs';
import { TechnologiesData } from '@/components/Data/Technologies';
import Project from '@/Components/Project'

export default function Projects({ auth }: PageProps<{}>) {
    const [jobs, setJobs] = useState<any[]>([]);
    const [technologies, setTechnologies] = useState<any[]>([]);
    const [activeTechnology, setActiveTechnology] = useState<any>(null);

    useEffect(() => {
        setJobs(JobList);
        setTechnologies(TechnologiesData);
        setActiveTechnology('*');
    }, []);

    const filterProjects = (tech: any) => {
        setActiveTechnology(tech); // set active tech

        if (tech === '*') { // if it's 'All', re load all
            setJobs(JobList);
        } else { // otherwise filter by tech
            setJobs((prevState: any) => {
                const newState = JobList.map(obj => {
                    const tmp = obj.projects.filter(project => project.technologies.indexOf(tech) !== -1)
                    // console.log(tmp);
                    return { ...obj, projects: tmp };
                });
                return newState;
            });
        }
    }

    return (
        <>
            <Head>
                {/* <link rel="canonical" href={process.env.NEXT_PUBLIC_APP_URL + '/projects'} /> */}
                <title>Projects | Piero Nanni</title>
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
                                    <img key={id} src={'../img/' + tech.key + '.webp'} alt={tech.name} height={20} width={20} />
                                }
                                <span>{tech.name}</span>
                            </div>
                        )}
                    </div>
                }

                {jobs?.length > 0 &&
                    <>
                        {jobs.map(job =>
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
                        )}
                    </>
                }
            </Layout>
        </>
    );
}
