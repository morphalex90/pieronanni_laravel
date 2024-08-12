import { Link, Head, useForm } from '@inertiajs/react';
import { PageProps } from '@/types';
import { motion } from 'framer-motion';
import Layout from '@/Layouts/Layout'
import { FormEventHandler, useState } from 'react';
import { Transition } from '@headlessui/react';
import InputError from '@/Components/InputError';

export default function Contact({ auth }: PageProps<{}>) {

    const handleChange = (e: any) => {
        const { name, value } = e.target;
        setData(name, value);
    }

    const { data, setData, post, errors, processing, recentlySuccessful, progress } = useForm({
        name: '',
        email: '',
        message: '',
        privacy: false,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('contact.store'));
    };

    return (
        <>
            <Head>
                {/* <link rel="canonical" href={process.env.NEXT_PUBLIC_APP_URL + '/contact'} /> */}
                <title>Contact | Piero Nanni</title>
                <meta name="description" content="Have some questions? Need help? Feel free to ask me everything you need" />

                <meta property="og:type" content="profile" />
                <meta property="og:title" content="Contact | Piero Nanni" />
                <meta property="og:description" content="Have some questions? Need help? Feel free to ask me everything you need" />
                <meta property="og:image" content="" />
                {/* <meta property="og:url" content={process.env.NEXT_PUBLIC_APP_URL + '/contact'} /> */}
            </Head>

            <Layout className="contact">
                <h1>Contact</h1>

                <div className="d-flex">
                    <motion.div initial={{ y: 10, opacity: 0 }} animate={{ y: 0, opacity: 1 }} transition={{ duration: 0.3 }}>
                        {/* <p>Thanks for wanting to get in touch! Do you have any questions? Don&#39;t esitate to contact me</p> */}
                        <p>While you&#39;ll be waiting for an answer, treat yourself with some good music from my personal playlist</p>
                        <p>Looking forward to hearing from you and have a wonderful {new Date().toLocaleDateString('en-GB', { weekday: 'long' }).toLowerCase()}!</p>
                    </motion.div>

                    <motion.div initial={{ y: 10, opacity: 0 }} animate={{ y: 0, opacity: 1 }} transition={{ duration: 0.3, delay: 0.2 }}>
                        <iframe style={{ borderRadius: 12 }} src="https://open.spotify.com/embed/playlist/3SjvhmS9oUWxUZehcyhYrT?utm_source=generator&theme=1" width="100%" height="380" frameBorder="0" allowFullScreen allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy" title="Spotify"></iframe>
                        {/* <Songs /> */}
                    </motion.div>

                    <motion.div initial={{ y: 10, opacity: 0 }} animate={{ y: 0, opacity: 1 }} transition={{ duration: 0.3, delay: 0.4 }}>
                        <form className="form" onSubmit={submit}>
                            <div className="d-flex">
                                <div className="form__field">
                                    <label htmlFor="field_name">Name</label>
                                    <input name="name" id="field_name" type="text" onChange={handleChange} value={data.name} placeholder="John Doe" required />
                                    <InputError className="mt-2" message={errors.name} />
                                </div>

                                <div className="form__field">
                                    <label htmlFor="field_email">Email</label>
                                    <input name="email" id="field_email" type="email" onChange={handleChange} value={data.email} placeholder="john@doe.com" required />
                                    <InputError className="mt-2" message={errors.email} />

                                </div>
                            </div>

                            <div className="form__field">
                                <label htmlFor="field_message">Message</label>
                                <textarea name="message" id="field_message" onChange={handleChange} value={data.message} placeholder="Write me anything you want" required></textarea>
                                <InputError className="mt-2" message={errors.message} />
                            </div>

                            <div className="d-flex">
                                <div>
                                    <label htmlFor="privacy">
                                        <input name="privacy" id="privacy" type="checkbox" onChange={handleChange} defaultChecked={data.privacy} required />
                                        <span> Privacy</span>
                                    </label>
                                    <InputError className="mt-2" message={errors.privacy} />
                                </div>

                                <button className="button" type="submit" disabled={processing}>{processing ? 'Sending' : 'Send'}</button>
                            </div>
                        </form>

                        {/* {response &&
                            <div style={{ marginTop: 20 }}>{response}</div>
                        } */}

                        <Transition
                            show={recentlySuccessful}
                            enter="transition ease-in-out"
                            enterFrom="opacity-0"
                            leave="transition ease-in-out"
                            leaveTo="opacity-0"
                        >
                            <p className="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                        </Transition>
                    </motion.div>
                </div>

            </Layout >
        </>
    );
}
