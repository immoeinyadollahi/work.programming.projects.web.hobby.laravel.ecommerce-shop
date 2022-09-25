import React, { useMemo } from "react";

import { useState } from "$hooks/core/state";
import UpdateAttributeValueModal from "./UpdateAttributeValueModal";

export default function Attribute({ attribute, categoryAttributes, updateVariation }) {
  const [isUpdateAttributeValueModalActive, setIsUpdateAttributeValueModalActive] = useState(false);
  const baseAttributeData = useMemo(() => categoryAttributes.find((attr) => attr.id === attribute.id), []);

  const handleUpdateValue = (value) => {
    if (value === attribute.attribute_value_id) return;
    updateVariation((variation) => {
      variation.attributes.find((attr) => attr.id === attribute.id).attribute_value_id = value;
    });
  };
  const attributeValue = useMemo(() => attribute.attribute_value_id && baseAttributeData.values.find((value) => value.id === attribute.attribute_value_id), [attribute.attribute_value_id]);
  return (
    <>
      <div className="variable-product-variation-attribute">
        <span className="me-4 fs-5">{baseAttributeData.fa}</span>
        <button className="btn btn-outline btn-outline-default btn-sm" onClick={() => setIsUpdateAttributeValueModalActive(true)}>
          {attributeValue ? attributeValue.fa : "تعیین نشده"}
        </button>
      </div>
      {isUpdateAttributeValueModalActive && <UpdateAttributeValueModal onClose={() => setIsUpdateAttributeValueModalActive(false)} onSubmit={handleUpdateValue} attributeValue={attributeValue} attributeData={attributeData} />}
    </>
  );
}
