import { useState } from 'react';
import { motion } from 'framer-motion';
import Modal from '@/Components/Modal'
import Icon from '@/Components/Icon';

import placeholder from '@/../img/placeholder.svg'

export default function Project({ project, delay }: { project: any, delay: number }) {
    const [modalShow, setModalShow] = useState(false);
    const [modalContent, setModalContent] = useState(null);

    return (
        <>
            <motion.div className="projects__single" initial={{ y: 10, opacity: 0 }} animate={{ y: 0, opacity: 1 }} transition={{ duration: 0.3, delay }} onClick={e => { setModalShow(true); setModalContent(project); }}>
                <div className="projects__single__image">
                    <img src={project?.files?.[0] ? project.files[0].url : placeholder} alt={project.title} title={project.title} width={333} height={200} />
                </div>

                <div className="projects__single__content">
                    <div className="projects__single__title">{project.title}</div>
                    <div className="projects__single__tech">
                        {project?.technologies?.map((tech: any) => {
                            return (
                                <Icon key={tech.id} technology={tech.key} />
                            )
                        })}
                    </div>
                </div>
            </motion.div >

            <Modal title={'Test'} onClose={() => setModalShow(false)} show={modalShow} content={modalContent} />
        </>
    );
}
