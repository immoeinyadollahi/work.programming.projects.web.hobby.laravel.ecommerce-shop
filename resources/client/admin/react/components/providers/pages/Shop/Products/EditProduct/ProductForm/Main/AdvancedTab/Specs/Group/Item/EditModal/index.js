import React, { useRef } from "react";
import { Modal } from "react-bootstrap";
import { useFormik } from "formik";

import * as specificationsHttp from "$http/shop/products/specifications";
import { useState } from "$hooks/core/state";
import useErrorHandler from "$hooks/common/useErrorHandler";

export default function EditItemModal({ item, onClose, onSubmit }) {
  const [isModalActive, setIsModalActive] = useState(true);
  const [isSubmiting, setIsSubmiting] = useState(false);
  const previouslySubmitedValueType = useRef();
  const { handleHttpError, clearErrors, errors } = useErrorHandler();
  const formik = useFormik({
    initialValues: {
      name: item.name,
      type: item.type,
      text_value: item.type === "text" ? item.value : "",
      boolean_value: item.type === "boolean" ? item.value : null,
    },
    async onSubmit({ name, type, text_value, boolean_value }) {
      clearErrors();
      previouslySubmitedValueType.current = type;
      setIsSubmiting(true);
      try {
        const {
          data: { item: updatedItem },
        } = await specificationsHttp.patchGroupItem(item.id, {
          name,
          type,
          value: type === "text" ? text_value : boolean_value,
        });
        setIsModalActive(false);
        onSubmit(updatedItem);
      } catch (err) {
        handleHttpError(err, {
          onBeforeDefaultAction: () => setIsSubmiting(false),
        });
      }
    },
  });
  const valueTypeErrors = {
    text: formik.values.type === "text" && previouslySubmitedValueType.current === "text" && errors.value,
    boolean: formik.values.type === "boolean" && previouslySubmitedValueType.current === "boolean" && errors.value,
  };
  return (
    <Modal show={isModalActive} onHide={() => setIsModalActive(false)} onExited={onClose} centered>
      <Modal.Header closeButton>
        <Modal.Title>ویرایش آیتم</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <form>
          <div className="mb-5">
            <label htmlFor="item-name-input" className="form-label required">
              نام
            </label>
            <input type="text" className={`form-control${errors.name ? " is-invalid" : ""}`} id="item-name-input" name="name" placeholder="نام آیتم را وارد کنید" value={formik.values.name} onChange={formik.handleChange} />
            {errors.name && <div className="invalid-feedback">{errors.name}</div>}
          </div>
          <div>
            <label className="form-label required">مقدار</label>
            <div className="mb-3">
              <div className="form-check form-check-custom form-check-sm mb-3">
                <input id="item-text-value-input" className={`form-check-input${valueTypeErrors.text ? " is-invalid" : ""}`} name="type" value="text" type="radio" checked={formik.values.type === "text"} onChange={formik.handleChange} />
                <label className="form-check-label" htmlFor="item-text-value-input">
                  متن
                </label>
              </div>
              {valueTypeErrors.text && <div className="invalid-feedback d-block mb-2">{valueTypeErrors.text}</div>}
              <textarea className="resize-none form-control" name="text_value" cols="30" rows="5" placeholder="متن مقدار را وارد کنید" value={formik.values.text_value} onChange={formik.handleChange} disabled={formik.values.type !== "text"}></textarea>
            </div>
            <div>
              <div className="form-check form-check-custom form-check-sm mb-3">
                <input id="item-boolean-value-input" className={`form-check-input${valueTypeErrors.boolean ? " is-invalid" : ""}`} name="type" value="boolean" type="radio" checked={formik.values.type === "boolean"} onChange={formik.handleChange} />
                <label className="form-check-label" htmlFor="item-boolean-value-input">
                  بله و خیر
                </label>
              </div>
              {valueTypeErrors.boolean && <div className="invalid-feedback d-block mb-2">{valueTypeErrors.boolean}</div>}
              <div className="d-flex align-items-center">
                <div className="form-check form-check-custom form-check-sm me-5">
                  <input id="item-boolean-value-yes-input" className="form-check-input w-15px h-15px" name="boolean_value" value="1" type="radio" checked={formik.values.boolean_value === "1"} onChange={formik.handleChange} disabled={formik.values.type !== "boolean"} />
                  <label className="form-check-label" htmlFor="item-boolean-value-yes-input">
                    بله
                  </label>
                </div>
                <div className="form-check form-check-custom form-check-sm">
                  <input id="item-boolean-value-no-input" className="form-check-input w-15px h-15px" name="boolean_value" value="0" type="radio" checked={formik.values.boolean_value === "0"} onChange={formik.handleChange} disabled={formik.values.type !== "boolean"} />
                  <label className="form-check-label" htmlFor="item-boolean-value-no-input">
                    خیر
                  </label>
                </div>
              </div>
            </div>
          </div>
        </form>
      </Modal.Body>
      <Modal.Footer>
        <button className="btn btn-primary" onClick={formik.handleSubmit} disabled={isSubmiting}>
          {isSubmiting ? <span className="spinner-border spinner-border-sm"></span> : "ذخیره"}
        </button>
        <button className="btn btn-secondary" onClick={() => setIsModalActive(false)} disabled={isSubmiting}>
          بستن
        </button>
      </Modal.Footer>
    </Modal>
  );
}
