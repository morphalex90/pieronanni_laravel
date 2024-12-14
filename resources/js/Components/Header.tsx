import { useState } from 'react'
import MainMenu from '@/Components/MainMenu'
import '../../css/_header.scss'


export default function Header() {
    const [isOpen, setIsOpen] = useState(false)

    return (
        <header className="header">
            <div className="header__container">

                <div className="header__menu">
                    <MainMenu position="header" className={isOpen ? '--open' : ''} />
                </div>

                <div className="header__burger">
                    <button type="button" className="header__burger__icon" onClick={() => setIsOpen(!isOpen)} aria-label="Open Menu Mobile" aria-expanded={isOpen ? 'true' : 'false'} aria-controls="main-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </header>
    )
}
