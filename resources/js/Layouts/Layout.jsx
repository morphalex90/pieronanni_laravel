import { useEffect, useState } from "react";
import Header from "@/Components/Header";
import Footer from "@/Components/Footer";
import Synt from "@/Components/Synt";


export default function Layout({ className = '', children }) {
    const [mainPadding, setMainPadding] = useState(null);

    useEffect(() => {
        const body = document.body;
        body.removeAttribute('class');
        body.classList.add(className);

        setMainPadding(document.getElementsByClassName('header')[0].offsetHeight);
    }, [mainPadding, className]);

    return (
        <>
            <Synt />
            <Header />
            <div className="content-wrapper" style={{ paddingTop: (mainPadding !== null ? mainPadding : 61) }}>
                <main id="main-content">
                    {children}
                </main>
            </div>
            <Footer />
        </>
    );
}
