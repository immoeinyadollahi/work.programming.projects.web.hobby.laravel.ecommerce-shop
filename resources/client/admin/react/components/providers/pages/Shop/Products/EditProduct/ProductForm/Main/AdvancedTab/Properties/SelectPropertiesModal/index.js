import React, { useMemo } from "react";
import { Modal, Accordion } from "react-bootstrap";
import { SortableContainer, SortableElement } from "react-sortable-hoc-rtl";

import * as propertiesHttp from "$http/shop/products/properties";
import { useState } from "$hooks/core/state";
import useData from "$hooks/actions/useData";
import useErrorHandler from "$hooks/common/useErrorHandler";
import SelectedValue from "./SelectedValue";

const SortableItem = SortableElement(SelectedValue);
const SortableList = SortableContainer(({ selectedValues, properties, handleRemoveSelectedValue }) => {
  const values = Array.from(selectedValues.entries());
  return (
    <div className="mt-5 border-top">
      {values.map(([propertyId, valueId], idx) => {
        const property = properties.find((property) => property.id === propertyId);
        const value = property.pivot.values.find((value) => value.id === valueId);
        return <SortableItem key={value.id} property={property} value={value} onRemove={() => handleRemoveSelectedValue(valueId)} index={idx} />;
      })}
    </div>
  );
});
export default function SelectPropertiesModal({ onClose, onSave }) {
  const [isModalActive, setIsModalActive] = useState(true);
  const [isSubmiting, setIsSubmiting] = useState(false);
  const [selectedValues, setSelectedValues, updateSelectedValues] = useState();
  const { data } = useData();
  const { handleHttpError } = useErrorHandler();
  const handleSaveChanges = async () => {
    try {
      setIsSubmiting(true);
      await propertiesHttp.postSave(data.product.id, { properties: Array.from(selectedValues.entries()).map(([propertyId, valueId]) => ({ property_id: propertyId, value_id: valueId })) });
      setIsModalActive(false);
      onSave();
    } catch (err) {
      handleHttpError(err, { onBeforeDefaultAction: () => setIsSubmiting(false) });
    }
  };
  const handleSelectedValuesSortEnd = ({ oldIndex, newIndex }) => {
    if (oldIndex === newIndex) return;
    const selectedValuesEntries = Array.from(selectedValues.entries());
    selectedValuesEntries.splice(newIndex, 0, selectedValuesEntries.splice(oldIndex, 1)[0]);
    setSelectedValues(new Map(selectedValuesEntries));
  };
  const handleRemoveSelectedValue = (selectedValueId) => {
    setSelectedValues(new Map(Array.from(selectedValues.entries()).filter(([, valueId]) => valueId !== selectedValueId)));
  };

  const categoryProperties = data.product.main_category.properties;
  return (
    <Modal show={isModalActive} onHide={() => setIsModalActive(false)} onExited={onClose} centered scrollable>
      <Modal.Header closeButton>
        <Modal.Title>ویرایش ویژگی ها</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <div>
          <Accordion>
            {categoryProperties.map((property, idx) => (
              <Accordion.Item eventKey={idx} key={property.id}>
                <Accordion.Header>{property.name}</Accordion.Header>
                <Accordion.Body>
                  {property.pivot.values.map((value, idx) => (
                    <div className={`form-check form-check-custom form-check-sm${idx > 0 ? " mt-3" : ""}`} key={value.id}>
                      <input id={`property-value-${value.id}`} className="form-check-input" type="radio" checked={selectedValues.get(property.id) === value.id} onChange={() => updateSelectedValues((selectedValues) => selectedValues.set(property.id, value.id))} />
                      <label className="form-check-label" htmlFor={`property-value-${value.id}`}>
                        {value.value}
                      </label>
                    </div>
                  ))}
                </Accordion.Body>
              </Accordion.Item>
            ))}
          </Accordion>
        </div>
        {selectedValues.size ? <SortableList selectedValues={selectedValues} properties={categoryProperties} handleRemoveSelectedValue={handleRemoveSelectedValue} onSortEnd={handleSelectedValuesSortEnd} useDragHandle /> : null}
      </Modal.Body>
      <Modal.Footer>
        <button className="btn btn-primary" onClick={handleSaveChanges} disabled={isSubmiting}>
          {isSubmiting ? <span className="spinner-border spinner-border-sm"></span> : "ذخیره تغییرات"}
        </button>
        <button className="btn btn-secondary" onClick={() => setIsModalActive(false)} disabled={isSubmiting}>
          بستن
        </button>
      </Modal.Footer>
    </Modal>
  );
}
