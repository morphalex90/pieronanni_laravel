import { createInertiaApp } from '@inertiajs/react'
import '../css/index.scss'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

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
        return <>{app}</>
    },
    progress: {
        color: '#4B5563',
    },
})
