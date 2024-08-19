import MainMenu from './MainMenu';

export default function Footer() {
    return (
        <footer className="footer">
            <div className="footer__container">
                <div className="footer__menu">
                    <MainMenu position="footer" />
                </div>

                <div className="footer__copy">
                    <p>{new Date().getFullYear()} &copy; Piero Nanni. Made with 🍺 in London</p>
                </div>
            </div>
        </footer>
    );
}
