import { Link, InertiaLinkProps } from '@inertiajs/react';

export default function NavLink({ active = false, children, ...props }: InertiaLinkProps & { active: boolean }) {
    return (
        <Link {...props} className={active ? 'is-active' : ''}>{children}</Link>
    );
}
