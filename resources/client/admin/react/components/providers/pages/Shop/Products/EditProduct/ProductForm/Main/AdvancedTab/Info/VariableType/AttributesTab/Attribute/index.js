import React, { useMemo } from "react";
import { SortableHandle } from "react-sortable-hoc-rtl";

import * as _Global from "$utilities/global";
import { useState } from "$hooks/core/state";
import useData from "$hooks/actions/useData";
import DeleteConfirmModal from "./DeleteConfirmModal";
import UpdateValuesModal from "./UpdateValuesModal";

const SortableDragHandle = SortableHandle(() => <span className="far fa-arrows cursor-move c-list-item-action"></span>);

export default function Attribute({ attribute, counter }) {
  const { data, setDataCallback } = useData();
  const categoryAttributes = data.product.main_category.attributes;
  const [isDeleteConfirmModalActive, setIsDeleteConfirmModalActive] = useState(false);
  const [isUpdateValuesModalActive, setIsUpdateValuesModalActive] = useState(false);
  const handleDeleteAttribute = () => {
    setDataCallback((data) => (data.product.variable_type.attributes = data.product.variable_type.attributes.filter((attr) => attr.id !== attribute.id)));
    _Global.set("shouldRefetchVariations", true);
  };
  const handleUpdateValues = (values) => {
    setDataCallback((data) => (data.product.variable_type.attributes.find((attr) => attr.id === attribute.id).values = values));
    _Global.set("shouldRefetchVariations", true);
  };
  const baseAttributeData = useMemo(() => categoryAttributes.find((attr) => attr.id === attribute.attribute_id), []);
  const values = attribute.values;
  return (
    <>
      <div className="d-flex align-items-center p-3">
        <span className="badge badge-circle badge-secondary me-3">{counter}</span>
        <div className="d-flex align-items-center flex-grow-1">
          <span className="me-4 fs-5">{baseAttributeData.fa}</span>
          {values.length ? (
            <button className="btn btn-outline btn-outline-primary" onClick={() => setIsUpdateValuesModalActive(true)}>
              {values.length} مورد انتخاب شده
            </button>
          ) : (
            <button className="btn btn-outline btn-outline-primary" onClick={() => setIsUpdateValuesModalActive(true)}>
              انتخاب مقادیر
              <span className="ms-2 fal fa-plus"></span>
            </button>
          )}
        </div>
        <div className="d-flex align-items-center">
          <SortableDragHandle />
          <span className="fas fa-trash text-danger c-list-item-action c-list-item-action" onClick={() => setIsDeleteConfirmModalActive(true)}></span>
        </div>
      </div>
      {isUpdateValuesModalActive && <UpdateValuesModal onClose={() => setIsUpdateValuesModalActive(false)} onSubmit={handleUpdateValues} attribute={attribute} baseAttributeData={baseAttributeData} />}
      {isDeleteConfirmModalActive && <DeleteConfirmModal onClose={() => setIsDeleteConfirmModalActive(false)} onConfirm={handleDeleteAttribute} attribute={attribute} />}
    </>
  );
}
