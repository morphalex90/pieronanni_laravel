export type CookieConsent = {
    version: number
    marketing: boolean
    decidedAt: string
}

export type CookieConsentState = {
    consent: CookieConsent | null
    isPreferencesOpen: boolean
}

export const CONSENT_COOKIE_NAME = 'cookie_consent'

/**
 * Bump when the cookie categories change, so everyone is asked again.
 */
const CONSENT_VERSION = 1

/**
 * Consent is asked again after six months, as regulators recommend.
 */
const CONSENT_MAX_AGE_SECONDS = 60 * 60 * 24 * 182

const SERVER_STATE: CookieConsentState = { consent: null, isPreferencesOpen: false }

const listeners = new Set<() => void>()

let state: CookieConsentState | null = null

function readConsentCookie(): CookieConsent | null {
    const rawValue = document.cookie
        .split('; ')
        .find((cookie) => cookie.startsWith(CONSENT_COOKIE_NAME + '='))
        ?.slice(CONSENT_COOKIE_NAME.length + 1)

    if (!rawValue) {
        return null
    }

    try {
        const consent = JSON.parse(decodeURIComponent(rawValue)) as Partial<CookieConsent>

        if (consent.version !== CONSENT_VERSION || typeof consent.marketing !== 'boolean' || typeof consent.decidedAt !== 'string') {
            return null
        }

        return { version: consent.version, marketing: consent.marketing, decidedAt: consent.decidedAt }
    } catch {
        return null
    }
}

function setState(nextState: CookieConsentState): void {
    state = nextState
    listeners.forEach((listener) => listener())
}

export function subscribeToCookieConsent(listener: () => void): () => void {
    listeners.add(listener)

    return () => listeners.delete(listener)
}

export function getCookieConsentState(): CookieConsentState {
    if (state === null) {
        state = { consent: readConsentCookie(), isPreferencesOpen: false }
    }

    return state
}

export function getServerCookieConsentState(): CookieConsentState {
    return SERVER_STATE
}

export function saveCookieConsent({ marketing }: { marketing: boolean }): void {
    const consent: CookieConsent = { version: CONSENT_VERSION, marketing, decidedAt: new Date().toISOString() }
    const secure = window.location.protocol === 'https:' ? '; Secure' : ''

    document.cookie = `${CONSENT_COOKIE_NAME}=${encodeURIComponent(JSON.stringify(consent))}; Max-Age=${CONSENT_MAX_AGE_SECONDS}; Path=/; SameSite=Lax${secure}`

    setState({ consent, isPreferencesOpen: false })
}

export function openCookiePreferences(): void {
    setState({ ...getCookieConsentState(), isPreferencesOpen: true })
}

export function closeCookiePreferences(): void {
    setState({ ...getCookieConsentState(), isPreferencesOpen: false })
}
