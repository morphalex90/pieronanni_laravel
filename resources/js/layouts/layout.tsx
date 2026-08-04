import type { ReactNode } from 'react'
import { useEffect } from 'react'
import Footer from '@/components/footer'
import Header from '@/components/header'
import Synt from '@/components/synt'

export function Layout({ className = '', children }: { className: string; children: ReactNode }) {
    useEffect(() => {
        const body = document.body
        body.removeAttribute('class')
        body.classList.add(className)
    }, [className])

    return (
        <>
            <a href="#main-content" className="visually-hidden">
                Skip to main content
            </a>
            <Synt />
            <Header />
            <div className="content-wrapper">
                {/* tabIndex -1 so the skip link actually moves focus, not just the scroll position */}
                <main id="main-content" tabIndex={-1}>
                    {children}
                </main>
            </div>
            <Footer />
        </>
    )
}
