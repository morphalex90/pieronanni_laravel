import { Form, usePage } from '@inertiajs/react'
import { motion } from 'framer-motion'
import { LoaderCircle, Send } from 'lucide-react'
import InputError from '@/components/input-error'
import { Meta } from '@/components/meta'
import Layout from '@/layouts/layout'
import '../../css/_form.scss'
import { contact } from '@/routes'
import { store } from '@/routes/contact'
import { type SharedData } from '@/types'

export default function Contact() {
    const { flash } = usePage<SharedData>().props

    return (
        <>
            <Meta
                url={contact().url}
                description="Have some questions? Need help? Feel free to ask me everything you need"
                title="Contact"
            />

            <Layout className="contact">
                <h1>Contact</h1>

                <div className="d-flex">
                    <motion.div initial={{ y: 10, opacity: 0 }} animate={{ y: 0, opacity: 1 }} transition={{ duration: 0.3 }}>
                        {/* <p>Thanks for wanting to get in touch! Do you have any questions? Don&#39;t esitate to contact me</p> */}
                        <p>While you&#39;ll be waiting for an answer, treat yourself with some good music from my personal playlist</p>
                        <p>
                            Looking forward to hearing from you and have a wonderful{' '}
                            {new Date().toLocaleDateString('en-GB', { weekday: 'long' }).toLowerCase()}!
                        </p>
                    </motion.div>

                    <motion.div initial={{ y: 10, opacity: 0 }} animate={{ y: 0, opacity: 1 }} transition={{ duration: 0.3, delay: 0.2 }}>
                        <iframe
                            style={{ borderRadius: 12 }}
                            src="https://open.spotify.com/embed/playlist/3SjvhmS9oUWxUZehcyhYrT?utm_source=generator&theme=1"
                            width="100%"
                            height="380"
                            frameBorder="0"
                            allowFullScreen
                            allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                            loading="lazy"
                            title="Spotify"
                        ></iframe>
                    </motion.div>

                    <motion.div initial={{ y: 10, opacity: 0 }} animate={{ y: 0, opacity: 1 }} transition={{ duration: 0.3, delay: 0.4 }}>

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
                                        ></textarea>
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
                                            {processing ? <LoaderCircle className="mr-2 h-5 w-5 animate-spin" /> : <Send className="mr-2 h-5 w-5" />}
                                            {processing ? 'Sending' : 'Send'}
                                        </button>
                                    </div>

                                    {recentlySuccessful && (
                                        <>
                                            {flash.success && (
                                                <p className="text-sm text-gray-600" style={{ marginTop: 20 }}>
                                                    {flash.success}
                                                </p>
                                            )}

                                            {flash.error && (
                                                <p className="text-sm text-gray-600" style={{ marginTop: 20 }}>
                                                    {flash.error}
                                                </p>
                                            )}
                                        </>
                                    )}
                                </>
                            )}
                        </Form>

                    </motion.div>
                </div>
            </Layout>
        </>
    )
}
