import { cn } from "@/lib/utils";
import { ReactNode } from "react";

export default function Section({ className, children }: { className?: string; children: ReactNode }) {
    return (
        <section className={cn('mx-auto max-w-7xl px-5', className)}>
            {children}
        </section>
    )
}
