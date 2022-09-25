import React from "react";
import { Tooltip, OverlayTrigger } from "react-bootstrap";
import { SortableHandle } from "react-sortable-hoc-rtl";
import _ from "lodash";

import { useState } from "$hooks/core/state";
import useData from "$hooks/actions/useData";
import DeleteConfirmModal from "./DeleteConfirmModal";
import EditModal from "./EditModal";

const SortableDragHandle = SortableHandle(() => <span className="far fa-arrows cursor-move c-list-item-action"></span>);

export default function Item({ item, counter }) {
  const { setDataCallback } = useData();
  const [isDeleteConfirmModalActive, setIsDeleteConfirmModalActive] = useState(false);
  const [isEditModalActive, setIsEditModalActive] = useState(false);
  const handleReplaceItem = (newData) => {
    setDataCallback((data) =>
      Object.assign(
        data.product.specification_groups.find((specGroup) => specGroup.id === group.id).items.find((groupItem) => groupItem.id === item.id),
        newData
      )
    );
  };
  const handleDeleteItem = () => {
    setDataCallback((data) => {
      const specGroup = data.product.specification_groups.find((specGroup) => specGroup.id === item.group_id);
      specGroup.items = specGroup.items.filter((groupItem) => groupItem.id !== item.id);
    });
  };
  return (
    <>
      <div className="d-flex align-items-center p-3">
        <div className="d-flex align-items-center flex-grow-1">
          <span className="badge badge-circle badge-secondary me-3">{counter}</span>
          <div className="d-flex align-items-center">
            <span className="fw-bold me-2">نام :</span>
            {item.name}
          </div>
          <span className="vr mx-3"></span>
          <div className="d-flex align-items-center">
            <span className="fw-bold me-2">مقدار : </span>
            {item.type === "boolean" ? (
              item.value === "1" ? (
                <span className="text-success far fa-check"></span>
              ) : (
                <span className="text-danger far fa-times"></span>
              )
            ) : item.value.length > 24 ? (
              <OverlayTrigger placement="bottom" overlay={<Tooltip>{item.value}</Tooltip>}>
                <span>{_.truncate(item.value, { length: 24 })}</span>
              </OverlayTrigger>
            ) : (
              <span>{item.value}</span>
            )}
          </div>
        </div>
        <div className="d-flex align-items-center">
          <SortableDragHandle />
          <span className="fas fa-pen text-warning c-list-item-action" onClick={() => setIsEditModalActive(true)}></span>
          <span className="fas fa-trash text-danger c-list-item-action" onClick={() => setIsDeleteConfirmModalActive(true)}></span>
        </div>
      </div>
      {isEditModalActive && <EditModal onClose={() => setIsEditModalActive(false)} onSubmit={handleReplaceItem} item={item} />}
      {isDeleteConfirmModalActive && <DeleteConfirmModal onClose={() => setIsDeleteConfirmModalActive(false)} onConfirm={handleDeleteItem} item={item} />}
    </>
  );
}
