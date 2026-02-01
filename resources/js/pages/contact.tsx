import { Form, usePage } from '@inertiajs/react'
import { motion } from 'framer-motion'
import InputError from '@/components/input-error'
import { Meta } from '@/components/meta'
import Layout from '@/layouts/layout'
import '../../css/_form.scss'
import { contact } from '@/routes'
import { store } from '@/routes/contact'
import { type SharedData } from '@/types'

const ANIMATION_DURATION = 0.3
const ANIMATION_DELAYS = [0, 0.2, 0.4] as const
const SPOTIFY_URL = 'https://open.spotify.com/embed/playlist/3SjvhmS9oUWxUZehcyhYrT?utm_source=generator&theme=1'
const SPOTIFY_IFRAME_HEIGHT = 380
const SPOTIFY_BORDER_RADIUS = 12
const MESSAGE_MARGIN_TOP = 20

const motionVariants = {
    initial: { y: 10, opacity: 0 },
    animate: { y: 0, opacity: 1 },
}

export default function Contact() {
    const { flash } = usePage<SharedData>().props
    const currentDay = new Date().toLocaleDateString('en-GB', { weekday: 'long' }).toLowerCase()

    return (
        <Layout className="contact">
            <Meta
                url={contact().url}
                description="Have some questions? Need help? Feel free to ask me everything you need"
                title="Contact"
            />

            <h1>Contact</h1>

            <div className="d-flex">
                <motion.div
                    initial={motionVariants.initial}
                    animate={motionVariants.animate}
                    transition={{ duration: ANIMATION_DURATION, delay: ANIMATION_DELAYS[0] }}
                >
                    <p>While you&#39;ll be waiting for an answer, treat yourself with some good music from my personal playlist</p>
                    <p>Looking forward to hearing from you and have a wonderful {currentDay}!</p>
                </motion.div>

                <motion.div
                    initial={motionVariants.initial}
                    animate={motionVariants.animate}
                    transition={{ duration: ANIMATION_DURATION, delay: ANIMATION_DELAYS[1] }}
                >
                    <iframe
                        style={{ borderRadius: SPOTIFY_BORDER_RADIUS }}
                        src={SPOTIFY_URL}
                        width="100%"
                        height={SPOTIFY_IFRAME_HEIGHT}
                        frameBorder="0"
                        allowFullScreen
                        allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                        loading="lazy"
                        title="Spotify"
                    />
                </motion.div>

                <motion.div
                    initial={motionVariants.initial}
                    animate={motionVariants.animate}
                    transition={{ duration: ANIMATION_DURATION, delay: ANIMATION_DELAYS[2] }}
                >
                    <Form {...store.form()} resetOnSuccess options={{ preserveScroll: true }} className="form">
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
                                            required
                                        />
                                        <InputError className="mt-2" message={errors.name} />
                                    </div>

                                    <div className="form__field">
                                        <label htmlFor="field_email">Email</label>
                                        <input
                                            name="email"
                                            id="field_email"
                                            type="email"
                                            placeholder="john@doe.com"
                                            required
                                        />
                                        <InputError className="mt-2" message={errors.email} />
                                    </div>
                                </div>

                                <div className="form__field">
                                    <label htmlFor="field_message">Message</label>
                                    <textarea
                                        name="message"
                                        id="field_message"
                                        placeholder="Write me anything you want"
                                        required
                                    />
                                    <InputError className="mt-2" message={errors.message} />
                                </div>

                                <div className="d-flex">
                                    <div>
                                        <label htmlFor="privacy">
                                            <input
                                                name="privacy"
                                                id="privacy"
                                                type="checkbox"
                                                required
                                            />
                                            <span> Privacy</span>
                                        </label>
                                        <InputError className="mt-2" message={errors.privacy} />
                                    </div>

                                    <button className="button" type="submit" disabled={processing}>
                                        {processing ? 'Sending' : 'Send'}
                                    </button>
                                </div>

                                {recentlySuccessful && (flash.success || flash.error) && (
                                    <p className="text-sm text-gray-600" style={{ marginTop: MESSAGE_MARGIN_TOP }}>
                                        {flash.success || flash.error}
                                    </p>
                                )}
                            </>
                        )}
                    </Form>
                </motion.div>
            </div>
        </Layout>
    )
}

