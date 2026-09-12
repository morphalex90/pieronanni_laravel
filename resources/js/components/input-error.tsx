import type { HTMLAttributes } from 'react'
import { cn } from '@/lib/utils'

/**
 * Field-level validation message.
 *
 * `role="alert"` makes assistive tech announce the message when it appears after
 * a failed submit; pair the `id` with the input's `aria-describedby` so the same
 * text is read again when the field regains focus.
 */
export default function InputError({ message, className = '', ...props }: HTMLAttributes<HTMLParagraphElement> & { message?: string }) {
    return message ? (
        <p {...props} role="alert" className={cn('text-sm text-red-600', className)}>
            {message}
        </p>
    ) : null
}
