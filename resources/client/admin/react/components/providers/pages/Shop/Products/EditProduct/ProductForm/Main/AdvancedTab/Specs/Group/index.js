import React, { useContext } from "react";
import { SortableHandle, SortableContainer, SortableElement } from "react-sortable-hoc-rtl";

import { useState } from "$hooks/core/state";
import useData from "$hooks/actions/useData";
import SpecsContext from "$contexts/pages/shop/ProductEdit/Specs";
import DeleteConfirmModal from "./DeleteConfirmModal";
import EditModal from "./EditModal";
import AddItemModal from "./AddItemModal";
import Item from "./Item";

const SortableDragHandle = SortableHandle(() => <span className="far fa-arrows cursor-move c-list-item-action"></span>);
const SortableItem = SortableElement(({ item, counter }) => <Item item={item} counter={counter} />);
const SortableList = SortableContainer(({ items }) => {
  return (
    <div className="border-start ps-3">
      {items.map((item, idx) => (
        <SortableItem key={item.id} item={item} counter={idx + 1} index={idx} />
      ))}
    </div>
  );
});

export default function Group({ group, counter }) {
  const { setDataCallback } = useData();
  const [isItemsExpanded, setIsItemsExpanded] = useState(false);
  const [isDeleteConfirmModalActive, setIsDeleteConfirmModalActive] = useState(false);
  const [isEditModalActive, setIsEditModalActive] = useState(false);
  const [isAddItemModalActive, setIsAddItemModalActive] = useState(false);
  const { setHasUnsavedChanges, updateSpecsOrdering } = useContext(SpecsContext);
  const handleDeleteGroup = () => {
    setDataCallback((data) => (data.product.specification_groups = data.product.specification_groups.filter((specGroup) => specGroup.id !== group.id)));
  };
  const handleReplaceGroup = (newData) => {
    setDataCallback((data) =>
      Object.assign(
        data.product.specification_groups.find((specGroup) => specGroup.id === group.id),
        newData
      )
    );
  };
  const handleAddItem = (item) => {
    setDataCallback((data) => data.product.specification_groups.find((specGroup) => specGroup.id === group.id).items.push(item));
    setIsItemsExpanded(true);
  };
  const handleItemsSortEnd = ({ oldIndex, newIndex }) => {
    if (oldIndex === newIndex) return;
    updateSpecsOrdering((state) => {
      const orderingGroup = state.find(({ groupId }) => groupId === group.id);
      orderingGroup.itemIds.splice(newIndex, 0, orderingGroup.itemIds.splice(oldIndex, 1)[0]);
    });
    setHasUnsavedChanges(true);
  };
  return (
    <>
      <div className="py-3">
        <div className="d-flex align-items-center">
          <div className="d-flex align-items-center flex-grow-1">
            <span className="badge badge-circle badge-secondary me-3">{counter}</span>
            <span onDoubleClick={() => setIsEditModalActive(true)}>{group.name}</span>
          </div>
          <div className="d-flex align-items-center">
            <span className="far fa-plus text-primary c-list-item-action" onClick={() => setIsAddItemModalActive(true)}></span>
            <SortableDragHandle />
            <span className={`fas fa-angle-${isItemsExpanded ? "up" : "down"} c-list-item-action`} onClick={() => setIsItemsExpanded(!isItemsExpanded)}></span>
            <span className="fas fa-pen text-warning c-list-item-action" onClick={() => setIsEditModalActive(true)}></span>
            <span className="fas fa-trash text-danger c-list-item-action" onClick={() => setIsDeleteConfirmModalActive(true)}></span>
          </div>
        </div>
        {isItemsExpanded && (
          <div className="pt-3">
            {group.items.length ? (
              <SortableList items={group.items} onSortEnd={handleItemsSortEnd} useDragHandle />
            ) : (
              <div className="alert alert-primary mb-0">
                در حال حاظر آیتمی برای این گروه وجود ندارد
                <button className="btn btn-sm btn-success ms-3">افزودن</button>
              </div>
            )}
          </div>
        )}
      </div>
      {isEditModalActive && <EditModal onClose={() => setIsEditModalActive(false)} onSubmit={handleReplaceGroup} group={group} />}
      {isDeleteConfirmModalActive && <DeleteConfirmModal onClose={() => setIsDeleteConfirmModalActive(false)} onConfirm={handleDeleteGroup} group={group} />}
      {isAddItemModalActive && <AddItemModal onClose={() => setIsAddItemModalActive(false)} onSubmit={handleAddItem} group={group} />}
    </>
  );
}
