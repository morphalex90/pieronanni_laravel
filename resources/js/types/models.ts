export type Flash = {
    success?: string
    warning?: string
    error?: string
}

export type SharedData = {
    flash: Flash
    [key: string]: unknown
}

export type CompanyType = {
    name: string
    url: string
}

export type TechnologyType = {
    id: number
    key: string
    name: string
}

export type ImageType = {
    id: number
    uri: string
    url: string
}

export type ProjectType = {
    id: number
    title: string
    url: string
    published_at: string
    github: string
    description?: string
    description_cv?: string
    technologies: TechnologyType[]
    media?: ImageType[]
}

export type JobType = {
    id: number
    title: string
    projects: ProjectType[]
    company: CompanyType
    location: string
    description: string
    description_cv: string
    started_at: string
    ended_at: string | null
}
