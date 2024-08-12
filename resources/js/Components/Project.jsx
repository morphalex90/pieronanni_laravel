import { useState } from 'react';
import { motion } from 'framer-motion';
import Modal from '@/components/Modal'

export default function Project({ project, delay }) {
    const [modalShow, setModalShow] = useState(false);
    const [modalContent, setModalContent] = useState(null);

    return (
        <>
            <motion.div className="projects__single" initial={{ y: 10, opacity: 0 }} animate={{ y: 0, opacity: 1 }} transition={{ duration: 0.3, delay }} onClick={e => { setModalShow(true); setModalContent(project); }}>
                <div className="projects__single__image">
                    <img src={'../img/projects/' + project.images[0]} alt={project.title} title={project.title} width={333} height={200} />
                </div>

                <div className="projects__single__content">
                    <div className="projects__single__title">{project.title}</div>
                    <div className="projects__single__tech">
                        {project.technologies.map((tech, id) => {
                            return (
                                <img key={id} src={'../img/' + tech + '.webp'} alt={tech} title={tech} height={20} width={20} />
                            )
                        })}
                    </div>
                </div>
            </motion.div >

            <Modal onClose={() => setModalShow(false)} show={modalShow} content={modalContent} />
        </>
    );
}
