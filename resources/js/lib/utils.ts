import type { InertiaLinkProps } from '@inertiajs/react'
import { clsx } from 'clsx'
import type { ClassValue } from 'clsx'
import type { SyntheticEvent } from 'react'
import { twMerge } from 'tailwind-merge'

import placeholder from '@/../img/placeholder.svg'

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs))
}

export function toUrl(url: NonNullable<InertiaLinkProps['href']>): string {
    return typeof url === 'string' ? url : url.url
}

/**
 * Swap a broken image for the placeholder, skipping when the placeholder itself fails to avoid an error loop.
 */
export function showImagePlaceholder(event: SyntheticEvent<HTMLImageElement>): void {
    if (!event.currentTarget.src.endsWith(placeholder)) {
        event.currentTarget.src = placeholder
    }
}
