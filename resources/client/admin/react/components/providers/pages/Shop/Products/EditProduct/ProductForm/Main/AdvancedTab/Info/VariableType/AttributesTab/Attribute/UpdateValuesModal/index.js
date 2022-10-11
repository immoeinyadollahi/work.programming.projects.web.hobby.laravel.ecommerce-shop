import React, { useMemo } from "react";
import { Modal } from "react-bootstrap";
import _ from "lodash";

import * as attributesHttp from "$http/shop/products/variable-type/attributes";
import { useState } from "$hooks/core/state";
import useErrorHandler from "$hooks/common/useErrorHandler";

export default function UpdateValuesModal({ product, attribute, categoryAttributes, onClose, onSubmit }) {
  const [isModalActive, setIsModalActive] = useState(true);
  const [isSubmiting, setIsSubmiting] = useState(false);
  const [initialSelectedAttributeValues, availableAttributeValues] = useMemo(() => [attribute.pivot.values.length ? _.map(attribute.pivot.values, "id") : [], categoryAttributes.find((categoryAttribute) => categoryAttribute.id === attribute.id).pivot.values], []);
  const [selectedAttributeValues, setSelectedAttributeValues] = useState(initialSelectedAttributeValues);
  const { handleHttpError } = useErrorHandler();

  const handleSaveChanges = async () => {
    setIsSubmiting(true);
    try {
      const {
        data: { values: attributeValues },
      } = await attributesHttp.patchValues(product.id, attribute.id, {
        values: selectedAttributeValues,
      });
      setIsModalActive(false);
      onSubmit(attributeValues);
    } catch (err) {
      handleHttpError(err, {
        onBeforeDefaultAction: () => setIsSubmiting(false),
      });
    }
  };

  return (
    <Modal show={isModalActive} onHide={() => setIsModalActive(false)} onExited={onClose} centered dialogClassName="variable-product-attributes-modal">
      <Modal.Header closeButton>
        <Modal.Title>انتخاب مقادیر</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        {availableAttributeValues.length ? (
          <div className="attribute-items">
            {availableAttributeValues.map((value) => {
              const isSelected = selectedAttributeValues.includes(value.id);
              const onChange = (e) => setSelectedAttributeValues(e.target.checked ? selectedAttributeValues.concat(value.id) : selectedAttributeValues.filter((attributeValue) => attributeValue !== value.id));
              switch (attribute.en) {
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
        {availableAttributeValues.length ? (
          <button className="btn btn-primary" onClick={handleSaveChanges} disabled={isSubmiting}>
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
