import React from "react";
import { DefaultEditor } from "react-simple-wysiwyg";
import { Modal } from "react-bootstrap";

import * as slideshowHttp from "$http/settings/slideshow";
import { useState } from "$hooks/core/state";
import useErrorHandler from "$hooks/common/useErrorHandler";

export default function AddSlideModal({ onClose, onSubmit }) {
  const [isModalActive, setIsModalActive] = useState(true);
  const [isSubmiting, setIsSubmiting] = useState(false);
  const [slide, setSlide, updateSlide, setSlideKeyValue] = useState({ title: "", description: "" });
  const { handleHttpError, clearErrors, errors } = useErrorHandler();
  const handleSubmit = async () => {
    clearErrors();
    setIsSubmiting(true);
    try {
      const {
        data: { newSlide },
      } = await slideshowHttp.postSlide({});
      setIsModalActive(false);
      onSubmit(newSlide);
    } catch (err) {
      handleHttpError(err, {
        onBeforeDefaultAction: () => setIsSubmiting(false),
      });
    }
  };
  return (
    <Modal show={isModalActive} onHide={() => setIsModalActive(false)} onExited={onClose} centered>
      <Modal.Header closeButton>
        <Modal.Title>افزودن اسلاید</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <form>
          <div className="mb-5">
            <label className="form-label required">عنوان</label>
            <input type="text" className={`form-control${errors.name ? " is-invalid" : ""}`} placeholder="عنوان اسلاید را وارد کنید" value={slide.title} onChange={(e) => setSlideKeyValue("title", e.target.value)} />
            {errors.title && <div className="invalid-feedback">{errors.title}</div>}
          </div>
          <div>
            <DefaultEditor value={slide.description} onChange={(e) => setSlideKeyValue("description", e.target.value)} />
          </div>
        </form>
      </Modal.Body>
      <Modal.Footer>
        <button className="btn btn-primary" onClick={handleSubmit} disabled={isSubmiting}>
          {isSubmiting ? <span className="spinner-border spinner-border-sm"></span> : "ثبت"}
        </button>
        <button className="btn btn-secondary" onClick={() => setIsModalActive(false)} disabled={isSubmiting}>
          بستن
        </button>
      </Modal.Footer>
    </Modal>
  );
}
