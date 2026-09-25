import { Link } from '@inertiajs/react'
import { Meta } from '@/components/meta'
import { Layout } from '@/layouts/layout'
import { contact, cookiePolicy, home, privacyPolicy } from '@/routes'

import '../../css/_legal.scss'

const LAST_UPDATED = '25 September 2026'

export default function PrivacyPolicy() {
    return (
        <Layout className="page-legal">
            <Meta
                url={privacyPolicy().url}
                title="Privacy Policy"
                description="How pieronanni.me collects, uses and protects your personal data, including contact form messages, CV downloads and error reports."
                breadcrumbs={[
                    { name: 'Home', url: home().url },
                    { name: 'Privacy Policy', url: privacyPolicy().url },
                ]}
            />

            <article className="legal">
                <h1 className="text-center">Privacy Policy</h1>
                <p className="legal__updated">Last updated: {LAST_UPDATED}</p>

                <section>
                    <h2>Who I am</h2>
                    <p>
                        This website is run by Piero Nanni, a web developer based in London, United Kingdom. I am the data controller for the personal
                        data collected through this site. You can reach me at <a href="mailto:piero.nanni@gmail.com">piero.nanni@gmail.com</a> or
                        through the <Link href={contact().url}>contact form</Link>.
                    </p>
                    <p>
                        This policy explains what personal data I collect, why I collect it and what rights you have under the UK General Data
                        Protection Regulation (UK GDPR) and the Data Protection Act 2018.
                    </p>
                </section>

                <section>
                    <h2>What I collect and why</h2>

                    <h3>Contact form</h3>
                    <p>When you send a message through the contact form I collect:</p>
                    <ul>
                        <li>your name, email address and message;</li>
                        <li>your IP address and browser user agent, to help spot spam and abuse.</li>
                    </ul>
                    <p>
                        I use this data only to read and reply to your enquiry. The legal basis is your consent, given when you tick the privacy box,
                        and my legitimate interest in answering messages and keeping the form free of spam.
                    </p>

                    <h3>CV downloads</h3>
                    <p>
                        When you open my CV I record the time of the request, your browser user agent and the country your request came from (as
                        reported by my CDN). I do not store your IP address for this. I use it to see how often the CV is viewed and to filter out
                        bots, which is my legitimate interest.
                    </p>

                    <h3>Server logs and error reports</h3>
                    <p>
                        Like most websites, the server keeps technical logs of requests, which can include your IP address, browser and the pages you
                        visited. If something breaks, an error report is sent to Sentry so I can fix it, and it may include similar request details.
                        The legal basis is my legitimate interest in keeping the site secure and working.
                    </p>

                    <h3>Cookies</h3>
                    <p>
                        This site sets only the cookies it needs to work, and uses no analytics or advertising tools of its own. The contact page also
                        loads Google reCAPTCHA, which sets a cookie to block spam, and an embedded Spotify player, which is only loaded if you accept
                        marketing cookies. See the <Link href={cookiePolicy().url}>Cookie Policy</Link> for the full list.
                    </p>
                </section>

                <section>
                    <h2>Who I share it with</h2>
                    <p>I do not sell your data or use it for marketing. It is shared only with the services that help run this site:</p>
                    <ul>
                        <li>
                            <strong>Google reCAPTCHA</strong>, which checks contact form submissions for spam. Google&apos;s{' '}
                            <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">
                                Privacy Policy
                            </a>{' '}
                            applies.
                        </li>
                        <li>
                            <strong>Resend</strong>, which delivers contact form messages to my inbox by email.
                        </li>
                        <li>
                            <strong>Sentry</strong>, which collects error reports.
                        </li>
                        <li>
                            <strong>Spotify</strong>, whose playlist player is embedded on the contact page. The player only loads if you accept
                            marketing cookies. Once it loads, your browser connects to Spotify, which receives your IP address and browser details and
                            sets cookies. The legal basis is your consent, which you can withdraw at any time from &quot;Cookie settings&quot; in the
                            footer. Spotify&apos;s{' '}
                            <a href="https://www.spotify.com/uk/legal/privacy-policy/" target="_blank" rel="noopener noreferrer">
                                Privacy Policy
                            </a>{' '}
                            applies.
                        </li>
                        <li>
                            <strong>Cloudflare</strong> and my hosting provider, which serve and protect the website.
                        </li>
                    </ul>
                    <p>
                        Some of these providers may process data outside the UK, for example in the United States. Where they do, the transfer is
                        covered by appropriate safeguards such as the UK International Data Transfer Agreement or the UK Extension to the EU-US Data
                        Privacy Framework.
                    </p>
                </section>

                <section>
                    <h2>How long I keep it</h2>
                    <p>
                        Contact form messages are kept only for as long as I need them to deal with your enquiry and any work that follows from it. CV
                        view records are kept as simple statistics. Server logs and error reports are kept for a limited time and then deleted. You
                        can ask me to delete your data at any time.
                    </p>
                </section>

                <section>
                    <h2>Your rights</h2>
                    <p>Under UK data protection law you have the right to:</p>
                    <ul>
                        <li>ask for a copy of the personal data I hold about you;</li>
                        <li>ask me to correct data that is wrong or incomplete;</li>
                        <li>ask me to delete your data;</li>
                        <li>object to, or ask me to restrict, how I use your data;</li>
                        <li>withdraw your consent at any time, without affecting anything done before you withdrew it;</li>
                        <li>receive your data in a portable format.</li>
                    </ul>
                    <p>
                        To use any of these rights, email me at <a href="mailto:piero.nanni@gmail.com">piero.nanni@gmail.com</a>. I will reply within
                        one month.
                    </p>
                    <p>
                        If you are unhappy with how I have handled your data, you can complain to the Information Commissioner&apos;s Office (ICO) at{' '}
                        <a href="https://ico.org.uk/make-a-complaint/" target="_blank" rel="noopener noreferrer">
                            ico.org.uk
                        </a>
                        .
                    </p>
                </section>

                <section>
                    <h2>Changes to this policy</h2>
                    <p>If I change how I handle personal data I will update this page and the date at the top.</p>
                </section>
            </article>
        </Layout>
    )
}
