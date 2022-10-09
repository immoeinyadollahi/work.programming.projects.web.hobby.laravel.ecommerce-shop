import React, { useMemo } from "react";
import { Modal, Accordion } from "react-bootstrap";
import { SortableContainer, SortableElement } from "react-sortable-hoc-rtl";

import * as propertiesHttp from "$http/shop/products/properties";
import { useState } from "$hooks/core/state";
import useData from "$hooks/actions/useData";
import useErrorHandler from "$hooks/common/useErrorHandler";
import SelectedProperty from "./SelectedProperty";

const SortableItem = SortableElement(SelectedProperty);
const SortableList = SortableContainer(({ selectedProperties, categoryProperties, handleRemoveSelectedProperty }) => {
  const properties = Array.from(selectedProperties.entries());
  return (
    <div className="mt-5 border-top">
      {properties.map(([propertyId, valueId], idx) => {
        const property = categoryProperties.find((property) => property.id === propertyId);
        const value = property.pivot.values.find((value) => value.id === valueId);
        return <SortableItem key={value.id} property={property} value={value} onRemove={() => handleRemoveSelectedProperty(propertyId)} index={idx} />;
      })}
    </div>
  );
});
export default function SelectPropertiesModal({ onClose, onSave }) {
  const [isModalActive, setIsModalActive] = useState(true);
  const [isSubmiting, setIsSubmiting] = useState(false);
  const {
    data: { product },
  } = useData();
  const initialSelectedProperties = useMemo(() => product.properties.reduce((acc, current) => (acc.set(current.id, current.pivot.property_value_id), acc), new Map()), []);
  const [selectedProperties, setSelectedProperties, updateSelectedProperties] = useState(initialSelectedProperties);
  const { handleHttpError } = useErrorHandler();
  const handleSaveChanges = async () => {
    try {
      setIsSubmiting(true);
      await propertiesHttp.postSave(product.id, { properties: Array.from(selectedProperties.entries()).map(([propertyId, valueId]) => ({ property_id: propertyId, value_id: valueId })) });
      setIsModalActive(false);
      onSave();
    } catch (err) {
      handleHttpError(err, { onBeforeDefaultAction: () => setIsSubmiting(false) });
    }
  };
  const handleSelectedPropertiesSortEnd = ({ oldIndex, newIndex }) => {
    if (oldIndex === newIndex) return;
    const selectedPropertiesEntries = Array.from(selectedProperties.entries());
    selectedPropertiesEntries.splice(newIndex, 0, selectedPropertiesEntries.splice(oldIndex, 1)[0]);
    setSelectedProperties(new Map(selectedPropertiesEntries));
  };
  const handleRemoveSelectedProperty = (selectedPropertyId) => {
    setSelectedProperties(new Map(Array.from(selectedProperties.entries()).filter(([propertyId]) => propertyId !== selectedPropertyId)));
  };

  const categoryProperties = product.main_category.properties;
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
                      <input id={`property-value-${value.id}`} className="form-check-input" type="radio" checked={selectedProperties.get(property.id) === value.id} onChange={() => updateSelectedProperties((selectedProperties) => selectedProperties.set(property.id, value.id))} />
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
        {selectedProperties.size ? <SortableList selectedProperties={selectedProperties} categoryProperties={categoryProperties} handleRemoveSelectedProperty={handleRemoveSelectedProperty} onSortEnd={handleSelectedPropertiesSortEnd} useDragHandle /> : null}
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
