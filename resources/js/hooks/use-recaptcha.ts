import { useCallback, useEffect } from 'react'
import { RECAPTCHA_SITE_KEY } from '@/lib/config'

declare global {
    interface Window {
        grecaptcha?: {
            ready: (callback: () => void) => void
            execute: (siteKey: string, options: { action: string }) => Promise<string>
        }
    }
}

const SCRIPT_ID = 'recaptcha-v3'

let scriptPromise: Promise<void> | null = null

/**
 * Injects the reCAPTCHA v3 loader once per page load and resolves when
 * `window.grecaptcha` is ready. Subsequent calls reuse the same promise.
 */
function loadRecaptchaScript(): Promise<void> {
    if (scriptPromise) {
        return scriptPromise
    }

    scriptPromise = new Promise<void>((resolve, reject) => {
        const existing = document.getElementById(SCRIPT_ID)

        if (existing) {
            resolve()

            return
        }

        const script = document.createElement('script')
        script.id = SCRIPT_ID
        script.src = `https://www.google.com/recaptcha/api.js?render=${encodeURIComponent(RECAPTCHA_SITE_KEY)}`
        script.async = true
        script.defer = true
        script.onload = () => resolve()
        script.onerror = () => {
            scriptPromise = null
            reject(new Error('Unable to load reCAPTCHA.'))
        }

        document.head.append(script)
    })

    return scriptPromise
}

/**
 * Returns a function that resolves a fresh reCAPTCHA v3 token for the given
 * action. Tokens expire after two minutes, so call it at submit time.
 *
 * Resolves to an empty string when no site key is configured, which keeps the
 * form usable in environments without Google credentials — the backend rule
 * skips verification under the same condition.
 */
export function useRecaptcha(action: string): () => Promise<string> {
    useEffect(() => {
        if (!RECAPTCHA_SITE_KEY) {
            return
        }

        void loadRecaptchaScript().catch(() => undefined)
    }, [])

    return useCallback(async () => {
        if (!RECAPTCHA_SITE_KEY) {
            return ''
        }

        await loadRecaptchaScript()

        const grecaptcha = window.grecaptcha

        if (!grecaptcha) {
            throw new Error('reCAPTCHA is unavailable.')
        }

        await new Promise<void>((resolve) => grecaptcha.ready(resolve))

        return grecaptcha.execute(RECAPTCHA_SITE_KEY, { action })
    }, [action])
}
