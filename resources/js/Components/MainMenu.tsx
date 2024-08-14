import github from '@/../img/github.svg';
import linkedin from '@/../img/linkedin.png';
import NavLink from "./NavLink";

export default function MainMenu({ position = '' }) {

    return (
        <nav role="navigation" className={'main-menu' + (position ? ' --' + position : '')}>
            <ul id={position === 'header' ? 'main-menu' : ''}>
                {position === 'header' &&
                    <li className="has-icon"><a href="https://github.com/morphalex90" title="GitHub" target="_blank" rel="noopener noreferrer"><img src={github} alt="GitHub" title="GitHub" height={26} width={26} /></a></li>
                }
                <li><NavLink href="/" active={route().current('homepage')} title="Home">Home</NavLink></li>
                <li><NavLink href="/about" active={route().current('about')} title="About">About</NavLink></li>
                <li><NavLink href="/projects" active={route().current('projects')} title="Projects">Projects</NavLink></li>
                <li><NavLink href="/contact" active={route().current('contact')} title="Contact">Contact</NavLink></li>
                <li><a href="/cv.pdf" title="cv">CV</a></li>

                {position === 'header' &&
                    <li className="has-icon"><a href="https://www.linkedin.com/in/piero-nanni-87407193" title="LinkedIn" target="_blank" rel="noopener noreferrer"><img src={linkedin} alt="LinkedIn" title="LinkedIn" height={26} width={26} /></a></li>
                }
            </ul>
        </nav>
    );
}
