import type { FormComponentRef } from '@inertiajs/core'
import { Form, usePage } from '@inertiajs/react'
import { m } from 'framer-motion'
import { type MouseEvent, useCallback, useRef, useState } from 'react'
import InputError from '@/components/input-error'
import { Meta } from '@/components/meta'
import { useIsClient } from '@/hooks/use-is-client'
import { useRecaptcha } from '@/hooks/use-recaptcha'
import { Layout } from '@/layouts/layout'
import '../../css/_form.scss'
import { contact } from '@/routes'
import { store } from '@/routes/contact'
import type { SharedData } from '@/types'

const ANIMATION_DURATION = 0.3
const ANIMATION_DELAYS = [0, 0.2, 0.4] as const
const SPOTIFY_URL = 'https://open.spotify.com/embed/playlist/3SjvhmS9oUWxUZehcyhYrT?utm_source=generator&theme=1'
const SPOTIFY_IFRAME_HEIGHT = 380
const RECAPTCHA_ACTION = 'contact'

const motionVariants = {
    initial: { y: 10, opacity: 0 },
    animate: { y: 0, opacity: 1 },
}

export default function Contact() {
    const { flash } = usePage<SharedData>().props
    // Computed on the client only: the weekday depends on the visitor's clock,
    // so rendering it during SSR would risk a hydration mismatch.
    const currentDay = useIsClient() ? new Date().toLocaleDateString('en-GB', { weekday: 'long' }).toLowerCase() : ''

    const executeRecaptcha = useRecaptcha(RECAPTCHA_ACTION)
    const formRef = useRef<FormComponentRef>(null)
    const recaptchaTokenRef = useRef('')
    const [recaptchaError, setRecaptchaError] = useState('')

    // The token is fetched asynchronously, which the <Form> submit event
    // cannot await, so the button drives the submission itself: validate the
    // fields natively, resolve a fresh token, then submit programmatically.
    const submitWithRecaptcha = useCallback(
        async (event: MouseEvent<HTMLButtonElement>) => {
            const formElement = event.currentTarget.form

            if (formElement && !formElement.reportValidity()) {
                return
            }

            setRecaptchaError('')

            try {
                recaptchaTokenRef.current = await executeRecaptcha()
            } catch {
                setRecaptchaError('The captcha could not be loaded. Please refresh the page and try again.')

                return
            }

            formRef.current?.submit()
        },
        [executeRecaptcha],
    )

    return (
        <Layout className="contact">
            <Meta
                url={contact().url}
                description="Get in touch with Piero Nanni, a full-stack developer based in London specialising in Laravel, React and WordPress."
                title="Contact Piero Nanni | Full-Stack Developer, London"
            />

            <h1 className="text-center">Contact Piero Nanni — Full-Stack Developer in London</h1>

            <div className="d-flex">
                <m.div
                    initial={motionVariants.initial}
                    animate={motionVariants.animate}
                    transition={{ duration: ANIMATION_DURATION, delay: ANIMATION_DELAYS[0] }}
                >
                    <p>While you&#39;ll be waiting for an answer, treat yourself with some good music from my personal playlist</p>
                    <p>Looking forward to hearing from you and have a wonderful {currentDay}!</p>
                </m.div>

                <m.div
                    initial={motionVariants.initial}
                    animate={motionVariants.animate}
                    transition={{ duration: ANIMATION_DURATION, delay: ANIMATION_DELAYS[1] }}
                >
                    <iframe
                        className="contact__spotify"
                        src={SPOTIFY_URL}
                        width="100%"
                        height={SPOTIFY_IFRAME_HEIGHT}
                        frameBorder="0"
                        allowFullScreen
                        allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                        loading="lazy"
                        title="Spotify"
                    />
                </m.div>

                <m.div
                    initial={motionVariants.initial}
                    animate={motionVariants.animate}
                    transition={{ duration: ANIMATION_DURATION, delay: ANIMATION_DELAYS[2] }}
                >
                    <Form
                        {...store.form()}
                        ref={formRef}
                        resetOnSuccess
                        options={{ preserveScroll: true }}
                        transform={(data) => ({ ...data, recaptcha_token: recaptchaTokenRef.current })}
                        className="form"
                    >
                        {({ processing, errors, recentlySuccessful }) => (
                            <>
                                <div className="d-flex">
                                    <div className="form__field">
                                        <label htmlFor="field_name">Name</label>
                                        <input
                                            name="name"
                                            id="field_name"
                                            type="text"
                                            placeholder="John Doe"
                                            autoComplete="name"
                                            aria-invalid={errors.name ? true : undefined}
                                            aria-describedby={errors.name ? 'field_name_error' : undefined}
                                            required
                                        />
                                        <InputError id="field_name_error" className="mt-2" message={errors.name} />
                                    </div>

                                    <div className="form__field">
                                        <label htmlFor="field_email">Email</label>
                                        <input
                                            name="email"
                                            id="field_email"
                                            type="email"
                                            placeholder="john@doe.com"
                                            autoComplete="email"
                                            aria-invalid={errors.email ? true : undefined}
                                            aria-describedby={errors.email ? 'field_email_error' : undefined}
                                            required
                                        />
                                        <InputError id="field_email_error" className="mt-2" message={errors.email} />
                                    </div>
                                </div>

                                <div className="form__field">
                                    <label htmlFor="field_message">Message</label>
                                    <textarea
                                        name="message"
                                        id="field_message"
                                        placeholder="Write me anything you want"
                                        aria-invalid={errors.message ? true : undefined}
                                        aria-describedby={errors.message ? 'field_message_error' : undefined}
                                        required
                                    />
                                    <InputError id="field_message_error" className="mt-2" message={errors.message} />
                                </div>

                                <div className="d-flex">
                                    <div>
                                        <label htmlFor="privacy">
                                            <input
                                                name="privacy"
                                                id="privacy"
                                                type="checkbox"
                                                aria-invalid={errors.privacy ? true : undefined}
                                                aria-describedby={errors.privacy ? 'privacy_error' : undefined}
                                                required
                                            />
                                            <span> Privacy</span>
                                        </label>
                                        <InputError id="privacy_error" className="mt-2" message={errors.privacy} />
                                    </div>

                                    <button className="button" type="button" onClick={submitWithRecaptcha} disabled={processing}>
                                        {processing ? 'Sending' : 'Send'}
                                    </button>
                                </div>

                                <InputError id="recaptcha_error" className="mt-2" message={recaptchaError || errors.recaptcha_token} />

                                {/* Required by Google when the reCAPTCHA badge is hidden or moved. */}
                                <p className="contact__recaptcha text-sm text-gray-600">
                                    This site is protected by reCAPTCHA and the Google{' '}
                                    <a href="https://policies.google.com/privacy" rel="noopener noreferrer" target="_blank">
                                        Privacy Policy
                                    </a>{' '}
                                    and{' '}
                                    <a href="https://policies.google.com/terms" rel="noopener noreferrer" target="_blank">
                                        Terms of Service
                                    </a>{' '}
                                    apply.
                                </p>

                                {/* Always mounted: an aria-live region that only appears once the
                                    message does is usually missed by screen readers. */}
                                <p aria-live="polite" className="contact__flash text-sm text-gray-600">
                                    {recentlySuccessful ? flash.success || flash.error : ''}
                                </p>
                            </>
                        )}
                    </Form>
                </m.div>
            </div>
        </Layout>
    )
}
