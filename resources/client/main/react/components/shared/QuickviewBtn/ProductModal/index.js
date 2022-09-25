import React from "react";
import { Modal } from "react-bootstrap";

import { useState } from "$hooks/core/state";

export default function ProductModal({ onClose, product }) {
    const [isModalActive, setIsModalActive] = useState(true);
    return (
        <Modal
            show={isModalActive}
            onHide={() => setIsModalActive(false)}
            onExited={onClose}
            centered
            size="xl"
        >
            <Modal.Header closeButton></Modal.Header>
            <Modal.Body>get from node-react-storyka</Modal.Body>
        </Modal>
    );
}
