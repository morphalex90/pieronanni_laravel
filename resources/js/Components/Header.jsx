import { useState } from 'react';
import MainMenu from './MainMenu';


export default function Header() {
    const [isOpen, setIsOpen] = useState(false);

    const openMobileMenu = () => {
        // have the body not scrollable when the menu is open
        if (isOpen) {
            document.body.classList.remove('--open');
        } else {
            document.body.classList.add('--open');
        }

        setIsOpen(!isOpen); // open / close the menu
    }

    return (
        <header className="header">
            <div className="header__container">

                <div className="header__menu">
                    <MainMenu position="header" />
                </div>

                <div className="header__burger">
                    <button type="button" className="header__burger__icon" onClick={() => openMobileMenu()} aria-label="Open Menu Mobile" aria-expanded={isOpen ? 'true' : 'false'} aria-controls="main-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>

            </div>
        </header>
    );
}
