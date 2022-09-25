import React, { useMemo } from "react";
import { SortableContainer, SortableElement } from "react-sortable-hoc-rtl";
import _ from "lodash";

import useData from "$hooks/actions/useData";
import { useState } from "$hooks/core/state";
import { useDependencyChangeEffect } from "$hooks/core/lifecycle";
import useHasUnsavedChanges from "$hooks/partials/useHasUnsavedChanges";
import SpecsContext from "$contexts/pages/shop/ProductEdit/Specs";
import AddGroupModal from "./AddGroupModal";
import Group from "./Group";
import SaveChangesBtn from "./SaveChangesBtn";

const SortableItem = SortableElement(({ group, counter }) => <Group group={group} counter={counter} />);
const SortableList = SortableContainer(({ groups }) => {
  return (
    <div>
      {groups.map((group, idx) => (
        <SortableItem key={group.id} group={group} counter={idx + 1} index={idx} />
      ))}
    </div>
  );
});

export default function Specs() {
  const { data, setDataCallback } = useData();
  const specGroups = data.product.specification_groups;
  const [isAddGroupModalActive, setIsAddGroupModalActive] = useState(false);
  const [hasUnsavedChanges, setHasUnsavedChanges] = useHasUnsavedChanges("AdvancedTab.Specs");
  const initialSpecsOrdering = useMemo(
    () =>
      specGroups.map((group) => ({
        groupId: group.id,
        itemIds: group.items.map((item) => item.id),
      })),
    []
  );
  const [specsOrdering, setSpecsOrdering, updateSpecsOrdering] = useState(initialSpecsOrdering);
  const orderedSpecGroups = useMemo(
    () =>
      specsOrdering
        .map(({ groupId, itemIds }) => {
          const group = specGroups.find((group) => group.id === groupId);
          if (!group) return null;
          const items = itemIds.map((itemId) => group.items.find((item) => item.id === itemId)).filter(Boolean);
          return { ...group, items };
        })
        .filter(Boolean),
    [specsOrdering, specGroups]
  );
  useDependencyChangeEffect(() => {
    if (specGroups.length > specsOrdering.length) {
      updateSpecsOrdering((state) => {
        const newGroup = _.last(specGroups);
        state.push({ groupId: newGroup.id, itemIds: newGroup.items });
      });
    } else if (specGroups.length < specsOrdering.length) {
      setSpecsOrdering(specsOrdering.filter(({ groupId }) => specGroups.some((group) => group.id === groupId)));
    } else {
      _.each(specsOrdering, ({ groupId, itemIds }) => {
        const group = specGroups.find((specGroup) => specGroup.id === groupId);
        if (group.items.length > itemIds.length) {
          updateSpecsOrdering((state) => {
            state.find(({ groupId: stateGroupId }) => stateGroupId === groupId).itemIds.push(_.last(group.items).id);
          });
          return false;
        }
        if (group.items.length < itemIds.length) {
          updateSpecsOrdering((state) => {
            state.find(({ groupId: stateGroupId }) => stateGroupId === groupId).itemIds.filter((itemId) => group.items.some((item) => item.id === itemId));
          });
          return false;
        }
      });
    }
  }, [specGroups]);
  const handleAddGroup = (group) => {
    setDataCallback((data) => data.product.specification_groups.push(group));
  };
  const handleGroupsSortEnd = ({ oldIndex, newIndex }) => {
    if (oldIndex === newIndex) return;
    updateSpecsOrdering((state) => {
      state.splice(newIndex, 0, state.splice(oldIndex, 1)[0]);
    });
    setHasUnsavedChanges(true);
  };
  const handleSaveOrdering = () => {
    setDataCallback((data) => {
      data.product.specification_groups = orderedSpecGroups;
    });
    setHasUnsavedChanges(false);
  };
  return (
    <SpecsContext.Provider value={{ setHasUnsavedChanges, updateSpecsOrdering }}>
      <div className="card card-flush card-widget">
        {/*begin::Card header*/}
        <div className="card-header">
          <div className="d-flex align-items-center">
            <div className="card-title">
              <h2>مشخصات</h2>
            </div>
            {hasUnsavedChanges && <SaveChangesBtn onSave={handleSaveOrdering} specsOrdering={specsOrdering} />}
          </div>
          <button className="btn btn-primary" onClick={() => setIsAddGroupModalActive(true)}>
            افزودن گروه
          </button>
        </div>
        {/*end::Card header*/}
        {/*begin::Card body*/}
        <div className="card-body">
          {orderedSpecGroups.length ? (
            <SortableList groups={orderedSpecGroups} onSortEnd={handleGroupsSortEnd} useDragHandle />
          ) : (
            <div className="alert alert-primary mb-0">
              در حال حاظر گروهی برای مشخصات وجود ندارد
              <button className="btn btn-sm btn-success ms-3" onClick={() => setIsAddGroupModalActive(true)}>
                افزودن
              </button>
            </div>
          )}
        </div>
        {/*end::Card body*/}
      </div>
      {isAddGroupModalActive && <AddGroupModal onClose={() => setIsAddGroupModalActive(false)} onSubmit={handleAddGroup} />}
    </SpecsContext.Provider>
  );
}
