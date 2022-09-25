import React from "react";
import { Modal } from "react-bootstrap";
import { useFormik } from "formik";

import * as specificationsHttp from "$http/shop/products/specifications";
import { useState } from "$hooks/core/state";
import useData from "$hooks/actions/useData";
import useErrorHandler from "$hooks/common/useErrorHandler";

export default function AddGroupModal({ onClose, onSubmit }) {
    const [isModalActive, setIsModalActive] = useState(true);
    const [isSubmiting, setIsSubmiting] = useState(false);
    const { data } = useData();
    const { handleHttpError, clearErrors, errors } = useErrorHandler();
    const formik = useFormik({
        initialValues: { name: "" },
        async onSubmit(values) {
            clearErrors();
            setIsSubmiting(true);
            try {
                const {
                    data: { group },
                } = await specificationsHttp.postGroup(data.product.id, values);
                setIsModalActive(false);
                onSubmit(group);
            } catch (err) {
                handleHttpError(err, {
                    onBeforeDefaultAction: () => setIsSubmiting(false),
                });
            }
        },
    });
    return (
        <Modal
            show={isModalActive}
            onHide={() => setIsModalActive(false)}
            onExited={onClose}
            centered
        >
            <Modal.Header closeButton>
                <Modal.Title>افزودن گروه</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <div>
                    <label className="form-label required">نام گروه</label>
                    <input
                        type="text"
                        className={`form-control${
                            errors.name ? " is-invalid" : ""
                        }`}
                        name="name"
                        placeholder="نام گروه را وارد کنید"
                        value={formik.values.name}
                        onChange={formik.handleChange}
                    />
                    {errors.name && (
                        <div className="invalid-feedback">{errors.name}</div>
                    )}
                </div>
            </Modal.Body>
            <Modal.Footer>
                <button
                    className="btn btn-primary"
                    onClick={formik.handleSubmit}
                    disabled={isSubmiting}
                >
                    {isSubmiting ? (
                        <span className="spinner-border spinner-border-sm"></span>
                    ) : (
                        "ثبت"
                    )}
                </button>
                <button
                    className="btn btn-secondary"
                    onClick={() => setIsModalActive(false)}
                    disabled={isSubmiting}
                >
                    بستن
                </button>
            </Modal.Footer>
        </Modal>
    );
}
