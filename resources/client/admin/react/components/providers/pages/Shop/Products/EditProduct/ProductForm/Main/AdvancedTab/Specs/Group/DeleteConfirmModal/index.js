import React from "react";
import { Modal } from "react-bootstrap";

import * as specificationsHttp from "$http/shop/products/specifications";
import { useState } from "$hooks/core/state";
import useErrorHandler from "$hooks/common/useErrorHandler";

export default function DeleteGroupConfirmModal({ group, onClose, onConfirm }) {
    const [isModalActive, setIsModalActive] = useState(true);
    const [isDeleting, setIsDeleting] = useState(false);
    const { handleHttpError } = useErrorHandler();
    const handleConfirm = async () => {
        setIsDeleting(true);
        try {
            await specificationsHttp.deleteGroup(group.id);
            setIsModalActive(false);
            onConfirm();
        } catch (err) {
            handleHttpError(err, {
                onBeforeDefaultAction: () => setIsDeleting(false),
            });
        }
    };
    return (
        <Modal
            show={isModalActive}
            onHide={() => setIsModalActive(false)}
            onExited={onClose}
            centered
        >
            <Modal.Header closeButton>
                <Modal.Title>حذف گروه</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <div className="d-flex flex-column align-items-center">
                    <span className="svg-icon svg-icon-5tx svg-icon-danger mb-5">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <rect
                                opacity="0.3"
                                x="2"
                                y="2"
                                width="20"
                                height="20"
                                rx="10"
                                fill="currentColor"
                            ></rect>
                            <rect
                                x="11"
                                y="14"
                                width="7"
                                height="2"
                                rx="1"
                                transform="rotate(-90 11 14)"
                                fill="currentColor"
                            ></rect>
                            <rect
                                x="11"
                                y="17"
                                width="2"
                                height="2"
                                rx="1"
                                transform="rotate(-90 11 17)"
                                fill="currentColor"
                            ></rect>
                        </svg>
                    </span>
                    <h3 className="m-0">آیا مطمئن هستید؟</h3>
                </div>
            </Modal.Body>
            <Modal.Footer>
                <button
                    className="btn btn-danger"
                    onClick={handleConfirm}
                    disabled={isDeleting}
                >
                    {isDeleting ? (
                        <span className="spinner-border spinner-border-sm"></span>
                    ) : (
                        "مطمئنم"
                    )}
                </button>
                <button
                    className="btn btn-secondary"
                    onClick={() => setIsModalActive(false)}
                    disabled={isDeleting}
                >
                    بستن
                </button>
            </Modal.Footer>
        </Modal>
    );
}
