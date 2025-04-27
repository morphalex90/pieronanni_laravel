import { HTMLAttributes } from 'react'

export default function InputError({ message, className = '', ...props }: HTMLAttributes<HTMLParagraphElement> & { message?: string }) {
    return message ? (
        <p {...props} className={className}>
            {message}
        </p>
    ) : null
}
