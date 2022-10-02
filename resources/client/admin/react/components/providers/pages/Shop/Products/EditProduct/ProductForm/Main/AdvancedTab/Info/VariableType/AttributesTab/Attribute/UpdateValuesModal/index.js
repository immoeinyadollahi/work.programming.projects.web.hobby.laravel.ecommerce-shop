import React, { useMemo } from "react";
import { Modal } from "react-bootstrap";
import { useFormik } from "formik";
import _ from "lodash";

import * as attributesHttp from "$http/shop/products/variable-type/attributes";
import { useState } from "$hooks/core/state";
import useErrorHandler from "$hooks/common/useErrorHandler";

export default function UpdateValuesModal({ attribute, baseAttributeData, onClose, onSubmit }) {
  const [isModalActive, setIsModalActive] = useState(true);
  const [isSubmiting, setIsSubmiting] = useState(false);
  const { handleHttpError } = useErrorHandler();
  const attributeValues = useMemo(() => (attribute.values.length ? attribute.values.reduce((acc, current) => ((acc[current.id] = current), acc), {}) : {}), []);
  const formik = useFormik({
    initialValues: { values: attributeValues },
    async onSubmit({ values }) {
      setIsSubmiting(true);
      try {
        await attributesHttp.patchValues(attribute.id, {
          values: Object.keys(values),
        });
        setIsModalActive(false);
        onSubmit(Object.values(values));
      } catch (err) {
        handleHttpError(err, {
          onBeforeDefaultAction: () => setIsSubmiting(false),
        });
      }
    },
  });
  const initialValues = baseAttributeData.pivot.values;
  return (
    <Modal show={isModalActive} onHide={() => setIsModalActive(false)} onExited={onClose} centered dialogClassName="variable-product-attributes-modal">
      <Modal.Header closeButton>
        <Modal.Title>انتخاب مقادیر</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        {initialValues.length ? (
          <div className="attribute-items">
            {initialValues.map((value) => {
              const isSelected = Boolean(formik.values.values[value.id]);
              const onChange = (e) =>
                formik.setFieldValue(
                  "values",
                  e.target.checked
                    ? {
                        ...formik.values.values,
                        [value.id]: value,
                      }
                    : _.omit(formik.values.values, value.id)
                );
              switch (baseAttributeData.en) {
                case "color":
                  return (
                    <div className="attributes-color-item" key={value.id}>
                      <input type="checkbox" className="color-item-input" id={`attribute-color-${value.id}`} checked={isSelected} onChange={onChange} />
                      <label
                        htmlFor={`attribute-color-${value.id}`}
                        className="color-item-label"
                        style={{
                          backgroundColor: value.meta.code,
                        }}
                      ></label>
                    </div>
                  );
                case "size":
                  return (
                    <div className="attributes-size-item" key={value.id}>
                      <input type="checkbox" className="size-item-input" id={`attribute-size-${value.id}`} checked={isSelected} onChange={onChange} />
                      <label htmlFor={`attribute-size-${value.id}`} className="size-item-label">
                        {value.en}
                      </label>
                    </div>
                  );
              }
            })}
          </div>
        ) : (
          <div className="alert alert-primary mb-0">مقداری در حال حاظر برای این خصوصیت وجود ندارد</div>
        )}
      </Modal.Body>
      <Modal.Footer>
        {initialValues.length ? (
          <button className="btn btn-primary" onClick={formik.handleSubmit} disabled={isSubmiting}>
            {isSubmiting ? <span className="spinner-border spinner-border-sm"></span> : "ذخیره تغییرات"}
          </button>
        ) : null}

        <button className="btn btn-secondary" onClick={() => setIsModalActive(false)} disabled={isSubmiting}>
          بستن
        </button>
      </Modal.Footer>
    </Modal>
  );
}
