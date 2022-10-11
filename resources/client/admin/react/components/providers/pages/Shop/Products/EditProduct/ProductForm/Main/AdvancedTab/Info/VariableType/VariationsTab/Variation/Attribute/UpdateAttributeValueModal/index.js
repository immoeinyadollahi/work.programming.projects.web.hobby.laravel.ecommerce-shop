import React from "react";
import { Modal } from "react-bootstrap";
import _ from "lodash";

import { useState } from "$hooks/core/state";

export default function UpdateAttributeValueModal({ attribute, availableAttributeValues, onClose, onSubmit }) {
  const [isModalActive, setIsModalActive] = useState(true);
  const [selectedValue, setSelectedValue] = useState(attribute.pivot.attribute_value_id);
  return (
    <Modal show={isModalActive} onHide={() => setIsModalActive(false)} onExited={onClose} centered dialogClassName="variable-product-attributes-modal">
      <Modal.Header closeButton>
        <Modal.Title>انتخاب مقدار</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        {availableAttributeValues.length ? (
          <div className="attribute-items">
            {availableAttributeValues.map((value) => {
              const isSelected = selectedValue ? selectedValue === value.id : false;
              const onChange = () => setSelectedValue(value.id);
              switch (attribute.en) {
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
        {availableAttributeValues.length ? (
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
