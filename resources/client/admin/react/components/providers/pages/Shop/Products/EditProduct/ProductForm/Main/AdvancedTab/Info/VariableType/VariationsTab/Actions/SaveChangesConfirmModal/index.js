import React from "react";
import { Modal } from "react-bootstrap";

import { useState } from "$hooks/core/state";

export default function SaveChangesConfirmModal({
    onClose,
    onConfirm,
    onDeny,
}) {
    const [isModalActive, setIsModalActive] = useState(true);
    return (
        <Modal
            show={isModalActive}
            onHide={() => setIsModalActive(false)}
            onExited={onClose}
            centered
        >
            <Modal.Header closeButton>
                <Modal.Title>ذخیره تغییرات فعلی</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <h3 className="m-0 text-center">
                    قبل از اجرا عملیات، تغییرات فعلی ذخیره شوند؟
                </h3>
            </Modal.Body>
            <Modal.Footer>
                <button
                    className="btn btn-primary"
                    onClick={() => (setIsModalActive(false), onConfirm())}
                >
                    بله
                </button>
                <button
                    className="btn btn-danger"
                    onClick={() => (setIsModalActive(false), onDeny())}
                >
                    خیر
                </button>
                <button
                    className="btn btn-secondary"
                    onClick={() => setIsModalActive(false)}
                >
                    لغو عملیات
                </button>
            </Modal.Footer>
        </Modal>
    );
}
