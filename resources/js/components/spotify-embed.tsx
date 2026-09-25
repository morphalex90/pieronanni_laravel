import { useCookieConsent } from '@/hooks/use-cookie-consent'
import { openCookiePreferences } from '@/lib/cookie-consent'

/**
 * Spotify sets marketing cookies as soon as its player loads, so the iframe
 * is only rendered once the visitor has accepted marketing cookies.
 */
export default function SpotifyEmbed({ src, height }: { src: string; height: number }) {
    const { consent } = useCookieConsent()

    if (!consent?.marketing) {
        return (
            <div className="contact__spotify contact__spotify--blocked" style={{ height }}>
                <p>This Spotify playlist is hidden because Spotify sets marketing cookies when it loads.</p>
                <button type="button" className="button" onClick={openCookiePreferences}>
                    Accept marketing cookies to see this
                </button>
            </div>
        )
    }

    return (
        <iframe
            className="contact__spotify"
            src={src}
            width="100%"
            height={height}
            frameBorder="0"
            allowFullScreen
            allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
            loading="lazy"
            title="Spotify"
        />
    )
}
