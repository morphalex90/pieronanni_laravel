export type * from './navigation'
export type * from './ui'

export type SharedData = {
    flash: Flash
    [key: string]: unknown
}

export interface Flash {
    success: string
    warning: string
    error: string
}

export interface CompanyType {
    name: string
    url: string
}

export interface ProjectType {
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

export interface TechnologyType {
    id: number
    key: string
    name: string
}

export interface ImageType {
    id: number
    uri: string
    url: string
}

export interface JobType {
    id: number
    title: string
    projects: ProjectType[]
    company: CompanyType
    location: string
    description: string
    description_cv: string
    started_at: Date
    ended_at: Date
}
