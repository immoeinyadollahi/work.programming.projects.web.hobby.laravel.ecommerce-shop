import React, { useMemo } from "react";

import { useState } from "$hooks/core/state";
import UpdateAttributeValueModal from "./UpdateAttributeValueModal";

export default function Attribute({ attribute, productAttributes, categoryAttributes, updateVariation }) {
  const [isUpdateAttributeValueModalActive, setIsUpdateAttributeValueModalActive] = useState(false);

  const handleUpdateValue = (valueId) => {
    if (valueId === attribute.pivot.attribute_value_id) return;
    updateVariation((variation) => {
      variation.attributes.find((attr) => attr.id === attribute.id).pivot.attribute_value_id = valueId;
    });
  };
  const availableAttributeValues = useMemo(() => {
    const categoryAttributeValues = categoryAttributes.find((categoryAttribute) => categoryAttribute.id === attribute.id).pivot.values;
    if (!productAttributes.some((productAttribute) => productAttribute.id === attribute.id)) return;
    const productAttributeValues = productAttributes.find((productAttribute) => productAttribute.id === attribute.id).pivot.values;
    return categoryAttributeValues.filter((categoryAttributeValue) => productAttributeValues.some((productAttributeValue) => productAttributeValue.id === categoryAttributeValue.id));
  }, []);
  const attributeValue = useMemo(() => attribute.pivot.attribute_value_id && availableAttributeValues.find((value) => value.id === attribute.pivot.attribute_value_id), [attribute.pivot.attribute_value_id]);
  return (
    <>
      <div className="variable-product-variation-attribute">
        <span className="me-4 fs-5">{attribute.fa}</span>
        <button className="btn btn-outline btn-outline-default btn-sm" onClick={() => setIsUpdateAttributeValueModalActive(true)}>
          {attributeValue ? attributeValue.fa : "تعیین نشده"}
        </button>
      </div>
      {isUpdateAttributeValueModalActive && <UpdateAttributeValueModal onClose={() => setIsUpdateAttributeValueModalActive(false)} onSubmit={handleUpdateValue} attribute={attribute} availableAttributeValues={availableAttributeValues} />}
    </>
  );
}
