import type { ReactNode} from 'react';
import { useEffect } from 'react'
import Footer from '@/components/footer'
import Header from '@/components/header'
import Synt from '@/components/synt'

export default function Layout({ className = '', children }: { className: string; children: ReactNode }) {
    useEffect(() => {
        const body = document.body
        body.removeAttribute('class')
        body.classList.add(className)
    }, [className])

    return (
        <>
            <Synt />
            <Header />
            <div className="content-wrapper">
                <main id="main-content">{children}</main>
            </div>
            <Footer />
        </>
    )
}
