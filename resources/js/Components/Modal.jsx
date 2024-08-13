import { useEffect, useState } from "react";
import ReactDOM from "react-dom";
import Markdown from 'react-markdown'

export default function Modal({ show, onClose, title, content }) {
    const [isBrowser, setIsBrowser] = useState(false);

    useEffect(() => {
        if (content != null) {
            setIsBrowser(true);
            // console.log(content);
        }
    }, [content]);

    const handleCloseClick = (e) => {
        if (e.target === e.currentTarget) {
            onClose();
        }
    };

    const modalContent = show ? (
        <div className="overlay" onClick={handleCloseClick}>
            <div className="modal">
                <div className="modal__header">
                    <h1 className="modal__title">{title || content.title}</h1>
                    <button className="modal__close" type="button" onClick={handleCloseClick} title="Close">[x]</button>
                </div>
                <div className="modal__content">
                    <div className="d-flex --reverse">

                        <div>
                            <div><Markdown>{content.description}</Markdown></div>

                            <div style={{ display: 'flex', gap: 10 }}>
                                <a href={content.url} className="button" target="_blank" rel="noreferrer">Visit site</a>
                                {content.github &&
                                    <a href={content.github} className="button" target="_blank" rel="noreferrer">GitHub</a>
                                }
                            </div>
                        </div>

                        <div>
                            {content?.images?.map((image, id) =>
                                <img key={id} src={'../img/projects/' + image} alt={title || content.title} title={title || content.title} />
                            )}
                        </div>

                    </div>

                </div>
            </div>
        </div>

    ) : null;

    if (isBrowser) {
        return ReactDOM.createPortal(
            modalContent,
            document.getElementById("modal-root")
        );
    } else {
        return null;
    }
};
