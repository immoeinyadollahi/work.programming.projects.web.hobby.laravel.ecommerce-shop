import React, { useMemo } from "react";
import { SortableContainer, SortableElement } from "react-sortable-hoc-rtl";
import Select from "react-select";
import _ from "lodash";

import * as attributesHttp from "$http/shop/products/variable-type/attributes";
import * as _Global from "$utilities/global";
import useData from "$hooks/actions/useData";
import useHasUnsavedChanges from "$hooks/partials/useHasUnsavedChanges";
import { useState } from "$hooks/core/state";
import { useDependencyChangeEffect } from "$hooks/core/lifecycle";
import useErrorHandler from "$hooks/common/useErrorHandler";
import Attribute from "./Attribute";
import SaveChangesBtn from "./SaveChangesBtn";

const SortableItem = SortableElement(({ attribute, counter }) => <Attribute attribute={attribute} counter={counter} />);
const SortableList = SortableContainer(({ attributes }) => {
  return (
    <div className="mt-5">
      {attributes.map((attribute, idx) => (
        <SortableItem key={attribute.id} attribute={attribute} counter={idx + 1} index={idx} />
      ))}
    </div>
  );
});

export default function AttributesTab() {
  const { data, setDataCallback } = useData();
  const { handleHttpError } = useErrorHandler();
  const productAttributes = data.product.variable_type.attributes;
  const categoryAttributes = data.product.main_category.attributes;
  const [isSubmiting, setIsSubmiting] = useState(false);
  const [hasUnsavedChanges, setHasUnsavedChanges] = useHasUnsavedChanges("AdvancedTab.VariableType.AttributesTab");
  const selectedAttributes = useMemo(() => categoryAttributes.filter((categoryAttribute) => productAttributes.some((attribute) => attribute.attribute_id === categoryAttribute.id)), [productAttributes.length]);
  const [initialAddableAttribute, initialAttributesOrdering] = useMemo(() => [categoryAttributes.find((attr) => !selectedAttributes.includes(attr))?.id || categoryAttributes[0].id, productAttributes.map((attribute) => attribute.id)], []);
  const [selectedAttribute, setSelectedAttribute] = useState(initialAddableAttribute);
  const [attributesOrdering, setAttributesOrdering, updateAttributesOrdering] = useState(initialAttributesOrdering);
  const orderedAttributes = useMemo(() => attributesOrdering.map((attrId) => productAttributes.find((attribute) => attribute.id === attrId)).filter(Boolean), [attributesOrdering, productAttributes]);
  useDependencyChangeEffect(() => {
    if (selectedAttributes.some((attr) => attr.id === selectedAttribute)) {
      const nextAttribute = categoryAttributes.find((attr) => !selectedAttributes.includes(attr));
      if (nextAttribute) setSelectedAttribute(nextAttribute.id);
    }
    if (productAttributes.length > attributesOrdering.length) {
      updateAttributesOrdering((state) => state.push(_.last(productAttributes).id));
    } else {
      setAttributesOrdering(attributesOrdering.filter((attrId) => productAttributes.some((attribute) => attribute.id === attrId)));
    }
  }, [productAttributes.length]);
  const handleAddAttribute = async () => {
    setIsSubmiting(true);
    try {
      const {
        data: { attribute },
      } = await attributesHttp.postAttribute(data.product.id, {
        attribute_id: selectedAttribute,
      });
      attribute.values = [];
      setDataCallback((data) => data.product.variable_type.attributes.push(attribute));
      _Global.set("shouldRefetchVariations", true);
      setIsSubmiting(false);
    } catch (err) {
      handleHttpError(err, {
        onBeforeDefaultAction: () => setIsSubmiting(false),
      });
    }
  };
  const handleAttributesSortEnd = ({ oldIndex, newIndex }) => {
    if (oldIndex === newIndex) return;
    updateAttributesOrdering((state) => {
      state.splice(newIndex, 0, state.splice(oldIndex, 1)[0]);
    });
    setHasUnsavedChanges(true);
  };
  const handleSaveOrdering = () => {
    setDataCallback((data) => {
      data.product.variable_type.attributes = orderedAttributes;
    });
    _Global.set("shouldRefetchVariations", true);
    setHasUnsavedChanges(false);
  };
  const hasAllAttributes = selectedAttributes.length === categoryAttributes.length;
  return (
    <>
      <div className="d-flex align-items-center justify-content-between">
        <div className="d-flex align-items-center">
          <span className="fs-4 whitespace-nowrap">خصوصیت :</span>
          <Select
            className="me-4 ms-2 min-w-100px"
            options={categoryAttributes.map((attribute) => ({ value: attribute.id, label: attribute.fa }))}
            isDisabled={hasAllAttributes}
            isOptionDisabled={(option) => selectedAttributes.some((attribute) => attribute.id === option.value)}
            isRtl={true}
            value={_.pickAs(
              categoryAttributes.find((attribute) => attribute.id === selectedAttribute),
              { value: "id", label: "fa" }
            )}
            onChange={(option) => setSelectedAttribute(option.value)}
          />
          <button className="btn btn-primary" onClick={handleAddAttribute} disabled={hasAllAttributes}>
            {isSubmiting ? <span className="spinner-border spinner-border-sm"></span> : " افزودن"}
          </button>
        </div>
        {hasUnsavedChanges && <SaveChangesBtn onSave={handleSaveOrdering} attributesOrdering={attributesOrdering} product={data.product} />}
      </div>
      {orderedAttributes.length ? (
        <>
          <SortableList attributes={orderedAttributes} onSortEnd={handleAttributesSortEnd} useDragHandle />
        </>
      ) : (
        <div className="alert alert-primary mb-0 mt-5">در حال حاظر خصوصیتی وجود ندارد</div>
      )}
    </>
  );
}
