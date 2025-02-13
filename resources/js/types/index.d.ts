export interface User {
    id: number
    name: string
    email: string
    email_verified_at?: string
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
    files?: ImageType[]
}

export interface TechnologyType {
    id: number
    key: string
    name: string
}

export interface JobType {
    id: number
    title: string
    projects: ProjectType[]
    company: Company
    location: string
    description: string
    description_cv: string
    started_at: Date
    ended_at: Date
}

export interface ImageType {
    id: number
    uri: string
    url: string
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>,> = T & {
    auth: {
        user: User;
    };
};
