import { Link } from '@inertiajs/react'
import '../../css/_footer.scss'
import { openCookiePreferences } from '@/lib/cookie-consent'
import { cookiePolicy, privacyPolicy } from '@/routes'
import MainMenu from './main-menu'

export default function Footer() {
    return (
        <footer className="footer">
            <div className="footer__container">
                <div className="footer__menu">
                    <MainMenu position="footer" />
                </div>

                <div className="footer__copy">
                    <p suppressHydrationWarning>{new Date().getFullYear()} &copy; Piero Nanni. Made with 🍺 in London</p>
                    <p className="footer__legal">
                        <Link href={privacyPolicy().url}>Privacy Policy</Link> · <Link href={cookiePolicy().url}>Cookie Policy</Link> ·{' '}
                        <button type="button" onClick={openCookiePreferences}>
                            Cookie settings
                        </button>
                    </p>
                </div>
            </div>
        </footer>
    )
}
