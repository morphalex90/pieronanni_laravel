import { type ReactNode } from 'react'
import { cn } from '@/lib/utils'

export default function Section({ className, children }: { className?: string; children: ReactNode }) {
    return <section className={cn('mx-auto max-w-7xl px-5', className)}>{children}</section>
}
