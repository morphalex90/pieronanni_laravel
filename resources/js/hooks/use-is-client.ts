import { useSyncExternalStore } from 'react'

const emptySubscribe = () => () => {}

/**
 * Returns `false` during SSR and the initial hydration render, then `true`
 * once running on the client. Use this to gate client-only values without
 * calling setState inside an effect (which triggers cascading renders).
 */
export function useIsClient(): boolean {
    return useSyncExternalStore(
        emptySubscribe,
        () => true,
        () => false,
    )
}
