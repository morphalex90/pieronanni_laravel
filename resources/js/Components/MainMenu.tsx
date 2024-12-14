import github from '@/../img/github.svg'
import NavLink from './NavLink'
import '../../css/_main-menu.scss'


export default function MainMenu({ className, position = '' }: { className?: string; position: string }) {
    return (
        <nav role="navigation" className={'main-menu' + (position ? ' --' + position : '') + (' ' + className)}>
            <ul id={position === 'header' ? 'main-menu' : ''}>
                {position === 'header' && (
                    <li className="has-icon">
                        <a href="https://github.com/morphalex90" title="GitHub" target="_blank" rel="noopener noreferrer">
                            <img src={github} alt="GitHub" title="GitHub" height={26} width={26} />
                        </a>
                    </li>
                )}
                <li>
                    <NavLink href={route('homepage')} active={route().current('homepage')} title="Home">
                        Home
                    </NavLink>
                </li>
                <li>
                    <NavLink href={route('about')} active={route().current('about')} title="About">
                        About
                    </NavLink>
                </li>
                <li>
                    <NavLink href={route('projects')} active={route().current('projects')} title="Projects">
                        Projects
                    </NavLink>
                </li>
                <li>
                    <NavLink href={route('contact')} active={route().current('contact')} title="Contact">
                        Contact
                    </NavLink>
                </li>
                <li>
                    <a href={route('cv')} title="cv">
                        CV
                    </a>
                </li>

                {position === 'header' && (
                    <li className="has-icon">
                        <a href="https://www.linkedin.com/in/piero-nanni-87407193" title="LinkedIn" target="_blank" rel="noopener noreferrer">
                            <svg enableBackground="new 0 0 48 48" id="Layer_1" version="1.1" viewBox="0 0 48 48">
                                <circle cx="24" cy="24" fill="black" r="24" />
                                <path d="M17.4,34.9h-4.6V20.1h4.6V34.9z M14.9,18.2L14.9,18.2c-1.7,0-2.8-1.1-2.8-2.6c0-1.5,1.1-2.6,2.8-2.6  c1.7,0,2.8,1.1,2.8,2.6C17.7,17.1,16.7,18.2,14.9,18.2z M35.9,34.9h-5.3v-7.7c0-2-0.8-3.4-2.6-3.4c-1.4,0-2.1,0.9-2.5,1.8  c-0.1,0.3-0.1,0.8-0.1,1.2v8h-5.2c0,0,0.1-13.6,0-14.8h5.2v2.3c0.3-1,2-2.5,4.6-2.5c3.3,0,5.9,2.1,5.9,6.7V34.9z" fill="#FFFFFF" />
                            </svg>
                        </a>
                    </li>
                )}
            </ul>
        </nav>
    )
}
