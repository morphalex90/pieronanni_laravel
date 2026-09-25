import { Link } from '@inertiajs/react'
import { useEffect, useRef, useState } from 'react'
import { useCookieConsent } from '@/hooks/use-cookie-consent'
import { useIsClient } from '@/hooks/use-is-client'
import { closeCookiePreferences, saveCookieConsent } from '@/lib/cookie-consent'
import { cookiePolicy } from '@/routes'

import '../../css/_cookie-banner.scss'

export default function CookieBanner() {
    const isClient = useIsClient()
    const { consent, isPreferencesOpen } = useCookieConsent()

    if (!isClient || (consent !== null && !isPreferencesOpen)) {
        return null
    }

    // Keyed so opening the settings while the first-visit banner is showing remounts it on the settings view.
    return (
        <CookieBannerDialog
            key={isPreferencesOpen ? 'settings' : 'banner'}
            openedFromSettings={isPreferencesOpen}
            canDismiss={consent !== null}
            initialMarketing={consent?.marketing ?? false}
        />
    )
}

function CookieBannerDialog({
    openedFromSettings,
    canDismiss,
    initialMarketing,
}: {
    openedFromSettings: boolean
    canDismiss: boolean
    initialMarketing: boolean
}) {
    const [isShowingPreferences, setIsShowingPreferences] = useState(openedFromSettings)
    const [isMarketingAllowed, setIsMarketingAllowed] = useState(initialMarketing)
    const headingRef = useRef<HTMLHeadingElement>(null)

    // When reopened from the footer, move focus into the banner and hand it back on close,
    // so keyboard users are not left on the page behind it.
    useEffect(() => {
        if (!openedFromSettings) {
            return
        }

        const trigger = document.activeElement as HTMLElement | null
        headingRef.current?.focus()

        return () => trigger?.focus()
    }, [openedFromSettings])

    useEffect(() => {
        if (!canDismiss) {
            return
        }

        const handleKeyDown = (e: KeyboardEvent) => {
            if (e.key === 'Escape') {
                closeCookiePreferences()
            }
        }

        document.addEventListener('keydown', handleKeyDown)

        return () => document.removeEventListener('keydown', handleKeyDown)
    }, [canDismiss])

    return (
        <section
            className="cookie-banner"
            role="dialog"
            aria-modal="false"
            aria-labelledby="cookie-banner-title"
            aria-describedby="cookie-banner-description"
        >
            <h2 id="cookie-banner-title" ref={headingRef} tabIndex={-1}>
                {isShowingPreferences ? 'Cookie settings' : 'Cookies'}
            </h2>

            <p id="cookie-banner-description">
                This site uses necessary cookies to work. With your consent, the Spotify player on the contact page will also set marketing cookies.
                You can change your mind at any time from &quot;Cookie settings&quot; in the footer. Read the{' '}
                <Link href={cookiePolicy().url}>Cookie Policy</Link>.
            </p>

            {isShowingPreferences && (
                <fieldset className="cookie-banner__categories">
                    <legend className="cookie-banner__legend">Cookie categories</legend>

                    <div className="cookie-banner__category">
                        <label htmlFor="cookie-necessary">
                            <input id="cookie-necessary" type="checkbox" checked disabled aria-describedby="cookie-necessary-description" />
                            <strong> Necessary</strong> <span>(always active)</span>
                        </label>
                        <p id="cookie-necessary-description">Keep the site secure, make the contact form work and remember your cookie choice.</p>
                    </div>

                    <div className="cookie-banner__category">
                        <label htmlFor="cookie-marketing">
                            <input
                                id="cookie-marketing"
                                type="checkbox"
                                checked={isMarketingAllowed}
                                onChange={(e) => setIsMarketingAllowed(e.target.checked)}
                                aria-describedby="cookie-marketing-description"
                            />
                            <strong> Marketing</strong>
                        </label>
                        <p id="cookie-marketing-description">
                            Set by Spotify when its playlist player loads on the contact page. Spotify may use them to track you and personalise ads.
                        </p>
                    </div>
                </fieldset>
            )}

            <div className="cookie-banner__actions">
                <button type="button" className="button" onClick={() => saveCookieConsent({ marketing: false })}>
                    Reject all
                </button>
                <button type="button" className="button" onClick={() => saveCookieConsent({ marketing: true })}>
                    Accept all
                </button>
                {isShowingPreferences ? (
                    <button type="button" className="button" onClick={() => saveCookieConsent({ marketing: isMarketingAllowed })}>
                        Save choices
                    </button>
                ) : (
                    <button type="button" className="button" onClick={() => setIsShowingPreferences(true)}>
                        Manage choices
                    </button>
                )}
                {canDismiss && (
                    <button type="button" className="cookie-banner__close" onClick={closeCookiePreferences}>
                        Cancel
                    </button>
                )}
            </div>
        </section>
    )
}
