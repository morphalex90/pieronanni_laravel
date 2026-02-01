import { Link } from '@inertiajs/react'
import { motion } from 'framer-motion'
import { useMemo, useState } from 'react'
import Markdown from 'react-markdown'
import { Meta } from '@/components/meta'
import Layout from '@/layouts/layout'
import '../../css/_timeline.scss'
import { about } from '@/routes'
import { type JobType } from '@/types'

const START_YEAR = 2011

const generateYears = (from: number, to: number): number[] =>
    Array.from({ length: to - from + 1 }, (_, i) => from + i)

const getJobDateRange = (startDate: string, endDate: string | null, currentYear: number) => {
    const startYear = parseInt(startDate.substring(0, 4))
    const endYear = endDate ? parseInt(endDate.substring(0, 4)) : currentYear
    return { startYear, endYear }
}

const formatJobDate = (date: string, endDate: string | null): string => {
    const startFormatted = new Date(date).toLocaleDateString('en-GB', {
        year: 'numeric',
        month: 'long',
    })

    if (!endDate) return startFormatted

    const endFormatted = new Date(endDate).toLocaleDateString('en-GB', {
        year: 'numeric',
        month: 'long',
    })

    return `${startFormatted} - ${endFormatted}`
}

interface TimelineJobItemProps {
    job: JobType
    isActive: boolean
    startYear: number
    totalYears: number
    currentYear: number
    onSelect: (jobId: number) => void
}

const TimelineJobItem = ({ job, isActive, startYear, totalYears, currentYear, onSelect }: TimelineJobItemProps) => {
    const { startYear: jobStartYear, endYear } = getJobDateRange(job.started_at, job.ended_at, currentYear)
    const marginLeft = jobStartYear - startYear
    const width = endYear - jobStartYear + 1

    const customProperties: React.CSSProperties = {
        '--unit-margin-left': marginLeft,
        '--unit-width': width,
        '--tot-years': totalYears,
    } as React.CSSProperties

    return (
        <div
            className={isActive ? '--active' : ''}
            style={customProperties}
            onClick={() => onSelect(job.id)}
            role="button"
            tabIndex={0}
        >
            {job.company.name}
        </div>
    )
}

// Job description component
interface JobDescriptionProps {
    job: JobType
    isActive: boolean
}

const JobDescription = ({ job, isActive }: JobDescriptionProps) => (
    <div className={isActive ? '--active' : ''}>
        <h3>{job.title}</h3>
        <div>
            <i>
                <a href={job.company.url} target="_blank" rel="noreferrer">
                    {job.company.name}
                </a>{' '}
                - {job.location} ({formatJobDate(job.started_at, job.ended_at)})
            </i>
        </div>
        <br />
        <div>
            <Markdown>{job.description}</Markdown>
        </div>
    </div>
)

export default function About({ jobs }: { jobs: JobType[] }) {
    const [activeJob, setActiveJob] = useState<number>(jobs.length > 0 ? jobs[0].id : 0)
    const currentYear = useMemo(() => new Date().getFullYear(), [])

    const years = useMemo(() => generateYears(START_YEAR, currentYear), [currentYear])

    return (
        <Layout className="about">
            <Meta
                url={about().url}
                description="Discover who Piero Nanni is, his career path and what he is doing at the moment"
                title="About"
            />

            <h1>About</h1>

            <div className="d-flex">
                <motion.section
                    initial={{ x: -50, opacity: 0 }}
                    animate={{ x: 0, opacity: 1 }}
                    transition={{ duration: 0.3, delay: 0.1 }}
                    className="about__jobs"
                >
                    <p>London</p>
                    <p>
                        <Link href="/contact" title="Contact me">
                            piero.nanni@gmail.com
                        </Link>
                    </p>
                    <p>
                        <a href="https://github.com/morphalex90" target="_blank" rel="noreferrer" title="GitHub">
                            github.com/morphalex90
                        </a>
                    </p>

                    <div className="timeline">
                        <h3 className="text-center">Jobs timeline</h3>

                        <div className="timeline__jobs">
                            {jobs.map((job) => (
                                <TimelineJobItem
                                    key={job.id}
                                    job={job}
                                    isActive={job.id === activeJob}
                                    startYear={START_YEAR}
                                    totalYears={years.length}
                                    currentYear={currentYear}
                                    onSelect={setActiveJob}
                                />
                            ))}
                        </div>

                        <div className="timeline__years">
                            {years.map((year) => (
                                <div key={year}>{year}</div>
                            ))}
                        </div>

                        <div className="timeline__descriptions">
                            {jobs.map((job) => (
                                <JobDescription
                                    key={job.id}
                                    job={job}
                                    isActive={job.id === activeJob}
                                />
                            ))}
                        </div>
                    </div>
                </motion.section>

                <motion.section
                    initial={{ x: 50, opacity: 0 }}
                    animate={{ x: 0, opacity: 1 }}
                    transition={{ duration: 0.3, delay: 0.3 }}
                >
                    <p>
                        From 2011 to 2015, I was part of an indie team based in Bologna, Italy (
                        <a
                            href="https://www.blackravenproduction.com/"
                            className="t-underline"
                            target="_blank"
                            rel="noreferrer"
                            title="Visit Black Raven"
                        >
                            Black Raven
                        </a>
                        ). We developed small games and programs for iOS and PC. I was responsible for the design and development of the website
                        and methods of database connection of the apps. As a secondary role, I also worked as a 3D modeler.
                        <br />
                        The years spent as part of this team enhanced my programming skills and developed the dynamics of working with a team.
                        Thanks to this experience, I have become the programmer I am today.
                    </p>

                    <p>
                        In May 2015, I was offered the opportunity to work at a web agency (
                        <a href="https://www.magicnet.it/" className="t-underline" target="_blank" rel="noreferrer" title="Visit Magic">
                            Magic
                        </a>
                        ), where I was trained on how companies develop websites and e-commerce platforms. During my three years with the company,
                        I expanded my knowledge of WordPress, Drupal, and Magento.
                    </p>

                    <p>
                        In June 2018, I moved to London to expand my knowledge and increase my English language skills.
                        <br />
                        After a couple of months I joined Purr, a web agency based in central London. Since starting, there have been many
                        interesting projects and new ways of building websites that I had never previously explored.
                    </p>

                    <p>
                        In May 2022, I joined{' '}
                        <a href="https://www.soundpickr.com/" className="t-underline" target="_blank" rel="noreferrer" title="Visit Soundpickr">
                            Soundpickr
                        </a>{' '}
                        and started working with Laravel and React to build a music streaming service. Sadly this startup shut down at the end of
                        2023 because of lack of foundings.
                    </p>

                    <p>
                        In January 2024, I joined{' '}
                        <a href="https://www.cyber-duck.co.uk/" className="t-underline" target="_blank" rel="noreferrer" title="Visit CyberDuck">
                            CyberDuck
                        </a>{' '}
                        (recently acquired by{' '}
                        <a href="https://www.caci.co.uk/" className="t-underline" target="_blank" rel="noreferrer" title="Visit CACI">
                            CACI
                        </a>
                        ) as a backend developer and started working on Worcester Bosch, a gigantic Laravel project.
                    </p>
                </motion.section>
            </div>
        </Layout>
    )
}
