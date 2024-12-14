import Footer from '@/Components/Footer'
import Header from '@/Components/Header'
import Synt from '@/Components/Synt'
import { ReactNode, useEffect } from 'react'

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
