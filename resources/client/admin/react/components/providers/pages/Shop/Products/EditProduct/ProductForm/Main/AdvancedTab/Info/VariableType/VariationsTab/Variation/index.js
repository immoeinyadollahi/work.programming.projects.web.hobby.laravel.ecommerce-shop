import React, { useContext } from "react";
import { SortableHandle } from "react-sortable-hoc-rtl";
import { Tooltip, OverlayTrigger } from "react-bootstrap";

import VariationsTabContext from "$contexts/pages/Shop/ProductEdit/VariableType/VariationsTab";
import { useState } from "$hooks/core/state";
import { useDependencyChangeEffect } from "$hooks/core/lifecycle";
import useData from "$hooks/actions/useData";
import DeleteConfirmModal from "./DeleteConfirmModal";
import Content from "./Content";
import Attribute from "./Attribute";

const SortableDragHandle = SortableHandle(() => <span className="far fa-arrows cursor-move c-list-item-action"></span>);

export default function Variation({ variation, counter }) {
  const { data, setDataCallback } = useData();
  const [isDeleteConfirmModalActive, setIsDeleteConfirmModalActive] = useState(false);
  const [isContentExpanded, setIsContentExpanded] = useState(false);
  const { variations, errors, setVariations, updateVariations, setHasUnsavedChanges, variationsFetchChange } = useContext(VariationsTabContext);

  const handleDeleteVariation = () => {
    setDataCallback((data) => (data.product.variable_type.variations = data.product.variable_type.variations.filter((dataVariation) => dataVariation.id !== variation.id)));
    setVariations(variations.filter((stateVariation) => stateVariation.id !== variation.id));
  };
  const updateVariation = (cb) => {
    updateVariations((variations) => cb(variations.find((stateVariation) => stateVariation.id === variation.id)));
    setHasUnsavedChanges(true);
  };
  useDependencyChangeEffect(() => {
    if (errors[variation.id]) {
      setIsContentExpanded(true);
    }
  }, [errors[variation.id]]);
  useDependencyChangeEffect(() => {
    setIsContentExpanded(false);
  }, [variationsFetchChange]);

  const variationErrors = errors[variation.id] || {};
  return (
    <>
      <div className="p-3">
        <div className="d-flex align-items-center">
          <div className="d-flex align-items-center flex-grow-1">
            <span className="badge badge-circle badge-secondary me-3">{counter}</span>
            {variation.attributes.map((attribute) => (
              <Attribute key={attribute.id} attribute={attribute} variation={variation} categoryAttributes={data.product.main_category.attributes} updateVariation={updateVariation} />
            ))}
          </div>
          <div className="d-flex align-items-center">
            {variationErrors.attributes && (
              <OverlayTrigger placement="bottom" overlay={<Tooltip>{variationErrors.attributes}</Tooltip>}>
                <span className="far fa-info-circle text-danger cursor-default c-list-item-action"></span>
              </OverlayTrigger>
            )}
            <SortableDragHandle />
            <span className={`fas fa-angle-${isContentExpanded ? "up" : "down"} c-list-item-action`} onClick={() => setIsContentExpanded(!isContentExpanded)}></span>
            <span className="fas fa-trash text-danger c-list-item-action" onClick={() => setIsDeleteConfirmModalActive(true)}></span>
          </div>
        </div>
        {isContentExpanded && <Content variation={variation} errors={variationErrors} updateVariation={updateVariation} />}
      </div>
      {isDeleteConfirmModalActive && <DeleteConfirmModal onClose={() => setIsDeleteConfirmModalActive(false)} onConfirm={handleDeleteVariation} variation={variation} />}
    </>
  );
}
