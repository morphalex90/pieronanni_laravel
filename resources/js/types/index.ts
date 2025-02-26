export interface Auth {
    user: User;
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
    company: CompanyType
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

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}
