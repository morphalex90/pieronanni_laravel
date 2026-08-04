import type { MouseEvent } from 'react'
import { useEffect, useRef } from 'react'
import ReactDOM from 'react-dom'
import Markdown from 'react-markdown'
import { useIsClient } from '@/hooks/use-is-client'
import type { ProjectType } from '@/types'

const FOCUSABLE = 'a[href], button:not([disabled]), input, select, textarea, [tabindex]:not([tabindex="-1"])'

export default function Modal({ show, onClose, title, content }: { show: boolean; onClose: () => void; title?: string; content: ProjectType }) {
    const mounted = useIsClient()
    const dialogRef = useRef<HTMLDivElement>(null)

    const handleCloseClick = (e: MouseEvent<HTMLDivElement> | MouseEvent<HTMLButtonElement>) => {
        if (e.target === e.currentTarget) {
            onClose()
        }
    }

    // Move focus into the dialog on open, keep Tab inside it, and hand focus back to
    // whatever opened it on close — otherwise keyboard users stay stranded on the page behind.
    useEffect(() => {
        if (!show) {
            return
        }

        const trigger = document.activeElement as HTMLElement | null
        dialogRef.current?.querySelector<HTMLElement>('.modal__close')?.focus()

        const handleKeyDown = (e: KeyboardEvent) => {
            if (e.key === 'Escape') {
                onClose()

                return
            }

            if (e.key !== 'Tab' || !dialogRef.current) {
                return
            }

            const items = [...dialogRef.current.querySelectorAll<HTMLElement>(FOCUSABLE)]

            if (items.length === 0) {
                return
            }

            const first = items[0]
            const last = items[items.length - 1]

            if (e.shiftKey && document.activeElement === first) {
                e.preventDefault()
                last.focus()
            } else if (!e.shiftKey && document.activeElement === last) {
                e.preventDefault()
                first.focus()
            }
        }

        document.addEventListener('keydown', handleKeyDown)

        return () => {
            document.removeEventListener('keydown', handleKeyDown)
            trigger?.focus()
        }
    }, [show, onClose])

    if (!mounted || !show || content == null) {
        return null
    }

    return ReactDOM.createPortal(
        <div className="overlay" onClick={handleCloseClick}>
            <div className="modal" ref={dialogRef} role="dialog" aria-modal="true" aria-labelledby="modal-title">
                <div className="modal__header">
                    <h2 className="modal__title" id="modal-title">
                        {title || content.title}
                    </h2>
                    <button className="modal__close" type="button" onClick={handleCloseClick} aria-label="Close dialog">
                        [x]
                    </button>
                </div>
                <div className="modal__content">
                    <div className="d-flex --reverse">
                        <div>
                            <Markdown>{content.description}</Markdown>

                            <div className="modal__actions">
                                <a href={content.url} className="button" target="_blank" rel="noreferrer">
                                    Visit site
                                </a>
                                {content.github && (
                                    <a href={content.github} className="button" target="_blank" rel="noreferrer">
                                        GitHub
                                    </a>
                                )}
                            </div>
                        </div>

                        <div>
                            {content?.media?.map((image) => (
                                <img key={image.id} src={image.url} alt={title || content.title} loading="lazy" />
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </div>,
        document.getElementById('modal-root')!,
    )
}
