import { createInertiaApp } from '@inertiajs/react'
import { LazyMotion } from 'framer-motion'
import '../css/index.scss'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

// Load framer-motion's DOM animation features in a separate async chunk so they
// stay out of the initial bundle. Components use the lightweight `m` proxy.
const loadFeatures = () => import('@/lib/motion-features').then((mod) => mod.default)

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    layout: (name) => {
        switch (true) {
            case name === 'welcome':
                return null
            default:
                return null
        }
    },
    strictMode: true,
    withApp(app) {
        return (
            <LazyMotion strict features={loadFeatures}>
                {app}
            </LazyMotion>
        )
    },
    progress: {
        color: '#4B5563',
    },
})
