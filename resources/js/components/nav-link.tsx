import { type InertiaLinkProps, Link, usePage } from '@inertiajs/react'

export default function NavLink({ active = false, children, ...props }: InertiaLinkProps & { active?: boolean }) {
    const { url } = usePage()

    // If active is not explicitly provided, determine it by comparing URLs
    const isActive = active !== false ? active : url === (typeof props.href === 'string' ? props.href : props.href?.url)

    return (
        <Link {...props} className={isActive ? 'is-active' : ''}>
            {children}
        </Link>
    )
}
