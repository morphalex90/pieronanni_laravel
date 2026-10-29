import type { SyntheticEvent } from 'react'

import placeholder from '@/../img/placeholder.svg'

/**
 * Swap a broken image for the placeholder, skipping when the placeholder itself fails to avoid an error loop.
 */
export function showImagePlaceholder(event: SyntheticEvent<HTMLImageElement>): void {
    if (!event.currentTarget.src.endsWith(placeholder)) {
        event.currentTarget.src = placeholder
    }
}
