import React from "react";
import { Modal } from "react-bootstrap";
import _ from "lodash";

import { useState } from "$hooks/core/state";

export default function UpdateAttributeValueModal({ attributeValue, attributeData, onClose, onSubmit }) {
  const [isModalActive, setIsModalActive] = useState(true);
  const [selectedValue, setSelectedValue] = useState(attributeValue && attributeValue.id);
  const initialValues = attributeData.values;
  return (
    <Modal show={isModalActive} onHide={() => setIsModalActive(false)} onExited={onClose} centered dialogClassName="variable-product-attributes-modal">
      <Modal.Header closeButton>
        <Modal.Title>انتخاب مقدار</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        {initialValues.length ? (
          <div className="attribute-items">
            {initialValues.map((value) => {
              const isSelected = selectedValue ? selectedValue === value.id : false;
              const onChange = (e) => setSelectedValue(value.id);
              switch (attributeData.en) {
                case "color":
                  return (
                    <div className="attributes-color-item" key={value.id}>
                      <input type="radio" className="color-item-input" id={`attribute-color-${value.id}`} checked={isSelected} onChange={onChange} />
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
                      <input type="radio" className="size-item-input" id={`attribute-size-${value.id}`} checked={isSelected} onChange={onChange} />
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
          <button
            className="btn btn-primary"
            onClick={() => {
              setIsModalActive(false);
              onSubmit(selectedValue);
            }}
          >
            ذخیره تغییرات
          </button>
        ) : null}

        <button className="btn btn-secondary" onClick={() => setIsModalActive(false)}>
          بستن
        </button>
      </Modal.Footer>
    </Modal>
  );
}
