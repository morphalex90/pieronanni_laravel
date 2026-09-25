import { Link } from '@inertiajs/react'
import { openCookiePreferences } from '@/lib/cookie-consent'
import { Meta } from '@/components/meta'
import { Layout } from '@/layouts/layout'
import { cookiePolicy, home, privacyPolicy } from '@/routes'

import '../../css/_legal.scss'

const LAST_UPDATED = '25 September 2026'

const COOKIES = [
    {
        name: 'piero-nanni-session',
        provider: 'pieronanni.me',
        category: 'Necessary',
        purpose: 'Keeps your session so forms and form errors work between pages.',
        duration: '2 hours',
    },
    {
        name: 'XSRF-TOKEN',
        provider: 'pieronanni.me',
        category: 'Necessary',
        purpose: 'Protects forms against cross-site request forgery.',
        duration: '2 hours',
    },
    {
        name: 'cookie_consent',
        provider: 'pieronanni.me',
        category: 'Necessary',
        purpose: 'Remembers your cookie choices so the banner is not shown on every page.',
        duration: '6 months',
    },
    {
        name: '_GRECAPTCHA',
        provider: 'Google (google.com)',
        category: 'Necessary',
        purpose: 'Set by Google reCAPTCHA on the contact page to tell people apart from spam bots.',
        duration: '6 months',
    },
    {
        name: 'sp_t, sp_landing',
        provider: 'Spotify (spotify.com)',
        category: 'Marketing',
        purpose:
            'Set by the Spotify playlist player on the contact page, only after you accept marketing cookies. Spotify uses them to identify your browser, measure how the player is used and personalise ads.',
        duration: 'Up to 1 year',
    },
]

export default function CookiePolicy() {
    return (
        <Layout className="page-legal">
            <Meta
                url={cookiePolicy().url}
                title="Cookie Policy"
                description="The cookies used on pieronanni.me, what each one does and how long it lasts. including the third-party cookies set by Google reCAPTCHA and the Spotify player."
                breadcrumbs={[
                    { name: 'Home', url: home().url },
                    { name: 'Cookie Policy', url: cookiePolicy().url },
                ]}
            />

            <article className="legal">
                <h1 className="text-center">Cookie Policy</h1>
                <p className="legal__updated">Last updated: {LAST_UPDATED}</p>

                <section>
                    <h2>What cookies are</h2>
                    <p>
                        Cookies are small text files that a website stores in your browser. They let the site remember things between requests, such
                        as the fact that you just submitted a form.
                    </p>
                </section>

                <section>
                    <h2>How this site uses cookies</h2>
                    <p>Cookies on this site fall into two categories:</p>
                    <ul>
                        <li>
                            <strong>Necessary</strong> cookies keep the site secure, make the contact form work (including Google reCAPTCHA, which
                            blocks spam) and remember your cookie choices. The site cannot work properly without them, so they do not need your
                            consent.
                        </li>
                        <li>
                            <strong>Marketing</strong> cookies are set by the Spotify playlist player on the contact page. The player is not loaded,
                            and Spotify sets no cookies, unless you accept marketing cookies.
                        </li>
                    </ul>
                    <p>
                        There are no analytics or advertising tools of my own. Third-party cookies are controlled by Google and Spotify, not by me,
                        and the names and lifetimes below may change when they update their services.
                    </p>

                    <div className="legal__table" role="region" aria-label="Cookies used on this site" tabIndex={0}>
                        <table>
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Provider</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Purpose</th>
                                    <th scope="col">Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                                {COOKIES.map((cookie) => (
                                    <tr key={cookie.name}>
                                        <td>
                                            <code>{cookie.name}</code>
                                        </td>
                                        <td>{cookie.provider}</td>
                                        <td>{cookie.category}</td>
                                        <td>{cookie.purpose}</td>
                                        <td>{cookie.duration}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    <p>
                        Cloudflare, which serves and protects this site, may also set short-lived security cookies (such as <code>__cf_bm</code>) to
                        filter out malicious traffic. See{' '}
                        <a
                            href="https://developers.cloudflare.com/fundamentals/reference/policies-compliances/cloudflare-cookies/"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            Cloudflare&apos;s cookie documentation
                        </a>{' '}
                        for details.
                    </p>
                </section>

                <section>
                    <h2>Changing your choices</h2>
                    <p>
                        You can accept or reject marketing cookies when you first visit, and change your mind at any time from &quot;Cookie
                        settings&quot; in the footer or with the button below. If you withdraw consent, the Spotify player is removed straight away.
                        Cookies Spotify has already set in your browser belong to Spotify, so to remove them, delete them in your browser settings.
                    </p>
                    <p>
                        <button type="button" className="button" onClick={openCookiePreferences}>
                            Change cookie settings
                        </button>
                    </p>
                    <p>
                        You can also block or delete cookies in your browser settings. If you block the cookies above, the site will still load, but
                        the contact form will not work. Blocking third-party cookies affects reCAPTCHA and the Spotify player. Spotify explains its
                        own cookies in its{' '}
                        <a href="https://www.spotify.com/uk/legal/cookies-policy/" target="_blank" rel="noopener noreferrer">
                            Cookie Policy
                        </a>
                        . The{' '}
                        <a href="https://ico.org.uk/for-the-public/online/cookies/" target="_blank" rel="noopener noreferrer">
                            ICO&apos;s guide to cookies
                        </a>{' '}
                        explains how to do this in the most common browsers.
                    </p>
                </section>

                <section>
                    <h2>More information</h2>
                    <p>
                        For how I handle personal data more generally, and how to contact me, see the{' '}
                        <Link href={privacyPolicy().url}>Privacy Policy</Link>.
                    </p>
                </section>
            </article>
        </Layout>
    )
}
