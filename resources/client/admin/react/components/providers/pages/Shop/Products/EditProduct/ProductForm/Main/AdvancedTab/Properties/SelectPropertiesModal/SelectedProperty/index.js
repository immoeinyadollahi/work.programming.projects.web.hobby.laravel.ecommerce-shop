import React from "react";
import { SortableHandle } from "react-sortable-hoc-rtl";

const SortableDragHandle = SortableHandle(() => <span className="far fa-arrows cursor-move c-list-item-action"></span>);

export default function SelectedProperty({ property, value, onRemove }) {
  return (
    <>
      <div className="d-flex align-items-center py-4" style={{ zIndex: 9999 }}>
        <div className="d-flex align-items-center flex-grow-1">
          <div className="d-flex align-items-center">
            <span className="fw-bold me-2">نام :</span>
            {property.name}
          </div>
          <span className="vr mx-3"></span>
          <div className="d-flex align-items-center">
            <span className="fw-bold me-2">مقدار : </span>
            {value.value}
          </div>
        </div>
        <div className="d-flex align-items-center">
          <SortableDragHandle />
          <span className="fas fa-trash text-danger c-list-item-action" onClick={onRemove}></span>
        </div>
      </div>
    </>
  );
}
