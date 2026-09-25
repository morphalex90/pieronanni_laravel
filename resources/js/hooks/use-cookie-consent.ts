import { useSyncExternalStore } from 'react'
import type { CookieConsentState } from '@/lib/cookie-consent'
import { getCookieConsentState, getServerCookieConsentState, subscribeToCookieConsent } from '@/lib/cookie-consent'

/**
 * Returns the visitor's cookie consent. During SSR and hydration nothing has
 * been consented to, so consent-gated content never renders on the server.
 */
export function useCookieConsent(): CookieConsentState {
    return useSyncExternalStore(subscribeToCookieConsent, getCookieConsentState, getServerCookieConsentState)
}
