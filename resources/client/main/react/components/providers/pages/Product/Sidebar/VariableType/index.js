import React, { useEffect, useMemo } from "react";
import _ from "lodash";

import { useState } from "$hooks/core/state";
import Foot from "../Foot";

export default function VariableType({ product }) {
  const { attributes: productAttributes, variations } = product.variable_type;

  const [isInitializing, setIsInitializing] = useState(true);
  const [attributes, setAttributes] = useState();
  // this refers to initial selected attribute values
  const initialSelectedAttributes = useMemo(() => variations.find((variation) => variation.id === product.selected_su.id).variable_product_type_attributes.reduce((acc, current) => ((acc[current.id] = current.pivot.attribute_value_id), acc), {}), []);
  // this is also selected attribute values not actual attributes
  const [selectedAttributes, setSelectedAttributes] = useState(initialSelectedAttributes);
  const selectedVariation = useMemo(() => variations.find((variation) => variation.variable_product_type_attributes.every((variationAttribute) => variationAttribute.pivot.attribute_value_id === selectedAttributes[variationAttribute.id])), [selectedAttributes]);
  const attributeNames = useMemo(() => !isInitializing && productAttributes.reduce((acc, current) => ((acc[current.id] = current.en), acc), {}), [isInitializing]);
  useEffect(() => {
    const previousAttributes = {};
    const attributes = productAttributes.map((attribute) => {
      const filteredVariations = variations.filter((variation) =>
        Object.entries(previousAttributes)
          .map((attribute) => [Number(attribute[0]), attribute[1]])
          .every(([previousAttributeId, previousAttributeValueId]) => variation.variable_product_type_attributes.some((variationAttribute) => variationAttribute.id === previousAttributeId && variationAttribute.pivot.attribute_value_id === previousAttributeValueId))
      );
      const attributeValues = _.uniqBy(
        filteredVariations.map((variation) => variation.variable_product_type_attributes.find((variationAttribute) => variationAttribute.id === attribute.id).pivot.value),
        "id"
      );
      previousAttributes[attribute.id] = initialSelectedAttributes[attribute.id];
      return { id: attribute.id, values: attributeValues };
    });
    setAttributes(attributes);
    setIsInitializing(false);
  }, []);

  const getAttributesWithValues = (selectedAttributes, excludeUntil) => {
    const selectedAttributesEntries = Object.entries(selectedAttributes).map((attribute) => [Number(attribute[0]), attribute[1]]);
    const previousAttributes = Object.fromEntries(selectedAttributesEntries.slice(0, selectedAttributesEntries.findIndex(([key]) => key === excludeUntil) + 1));
    const shouldNotChangeAttributes = attributes.slice(0, Object.keys(previousAttributes).length);
    const updatedAttributes = productAttributes.slice(productAttributes.findIndex((attr) => attr.id === excludeUntil) + 1).map((attribute) => {
      // 1. we should filter variations that have previous selected attribute values in their attributes
      const filteredVariations = variations.filter((variation) =>
        Object.entries(previousAttributes)
          .map((attribute) => [Number(attribute[0]), attribute[1]])
          .every(([previousAttributeId, previousAttributeValueId]) => variation.variable_product_type_attributes.some((variationAttribute) => variationAttribute.id === previousAttributeId && variationAttribute.pivot.attribute_value_id === previousAttributeValueId))
      );
      // 2. we get current attribute values from all filtered variation
      const attributeValues = _.uniqBy(
        filteredVariations.map((variation) => variation.variable_product_type_attributes.find((variationAttribute) => variationAttribute.id === attribute.id).pivot.value),
        "id"
      );
      // 3. add current attribute first mapped value to selectedAttributes
      previousAttributes[attribute.id] = attributeValues[0].id;

      return { id: attribute.id, values: attributeValues };
    });
    return [shouldNotChangeAttributes.concat(updatedAttributes), previousAttributes];
  };
  return isInitializing ? (
    <div className="d-flex justify-content-center">
      <span className="spinner-border spinner-border-sm"></span>
    </div>
  ) : (
    <>
      {attributes.map(({ id, values }) => {
        const isChecked = (value) => selectedAttributes[id] === value.id;
        const onChange = (value) => {
          const [attributes, newSelectedAttributes] = getAttributesWithValues(
            {
              ...selectedAttributes,
              [id]: value.id,
            },
            id
          );
          setSelectedAttributes(newSelectedAttributes);
          setAttributes(attributes);
        };
        switch (attributeNames[id]) {
          case "color":
            return (
              <div className="form-group product__option" key={id}>
                <label className="product__option-label">رنگ</label>
                <div className="input-radio-color">
                  <div className="input-radio-color__list">
                    {values.map((value) => (
                      <div className="attributes-color-item" key={value.id}>
                        <input type="checkbox" className="color-item-input" id={`attribute-color-${value.id}`} name="color" checked={isChecked(value)} onChange={() => onChange(value)} />
                        <label
                          htmlFor={`attribute-color-${value.id}`}
                          className="color-item-label"
                          style={{
                            backgroundColor: value.meta.code,
                          }}
                        ></label>
                      </div>
                    ))}
                  </div>
                </div>
              </div>
            );
          case "size":
            return (
              <div className="form-group product__option" key={id}>
                <label className="product__option-label">سایز</label>
                <div className="input-radio-label">
                  <div className="input-radio-label__list">
                    {values.map((value) => (
                      <div className="attributes-size-item" key={value.id}>
                        <input type="checkbox" className="size-item-input" id={`attribute-size-${value.id}`} name="size" checked={isChecked(value)} onChange={() => onChange(value)} />
                        <label htmlFor={`attribute-size-${value.id}`} className="size-item-label">
                          {value.en}
                        </label>
                      </div>
                    ))}
                  </div>
                </div>
              </div>
            );
        }
      })}
      <Foot su={selectedVariation} product={product} />
    </>
  );
}
