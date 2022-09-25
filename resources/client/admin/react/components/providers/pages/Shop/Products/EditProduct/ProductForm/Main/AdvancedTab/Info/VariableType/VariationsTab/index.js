import React, { useMemo, useEffect } from "react";
import { SortableContainer, SortableElement } from "react-sortable-hoc-rtl";
import _ from "lodash";

import * as variationsHttp from "$http/shop/products/variable-type/variations";
import * as _Global from "$utilities/global";
import VariationsTabContext from "$contexts/pages/Shop/ProductEdit/VariableType/VariationsTab";
import useData from "$hooks/actions/useData";
import useLoader from "$hooks/actions/useLoader";
import useHasUnsavedChanges from "$hooks/partials/useHasUnsavedChanges";
import { useState } from "$hooks/core/state";
import { useDependencyChangeEffect } from "$hooks/core/lifecycle";
import useErrorHandler from "$hooks/common/useErrorHandler";
import Actions from "./Actions";
import Variation from "./Variation";

const SortableItem = SortableElement(({ variation, counter }) => <Variation variation={variation} counter={counter} />);
const SortableList = SortableContainer(({ variations }) => {
  return (
    <div className="mt-5">
      {variations.map((variation, idx) => (
        <SortableItem key={variation.id} variation={variation} counter={idx + 1} index={idx} />
      ))}
    </div>
  );
});

export default function VariationsTab({ setActiveTab }) {
  const { data, setDataCallback } = useData();
  const { toggleLoader } = useLoader();
  const [hasUnsavedChanges, setHasUnsavedChanges] = useHasUnsavedChanges("AdvancedTab.VariableType.VariationsTab");
  const [isSavingChanges, setIsSavingChanges] = useState(false);
  const [variationsFetchChange, setVariationsFetchChange] = useState();
  const getStateVariations = () => data.product.variable_type.variations.map((variation) => getVariationForState(variation));
  const getVariationForState = (original) => {
    return {
      id: original.id,
      price: original.price ?? "",
      discounted_price: original.discounted_price ?? "",
      discount_expire: original.discount_expire ?? "",
      stock: original.stock ?? "",
      description: original.description || "",
      has_discount: Boolean(original.discounted_price),
      attributes: original.variable_product_type_attribute_pivots,
    };
  };
  const variationsList = useMemo(getStateVariations, []);
  const [variations, setVariations, updateVariations] = useState(variationsList);
  const { handleHttpError, clearErrors, errors } = useErrorHandler();

  const handleVariationsSortEnd = ({ oldIndex, newIndex }) => {
    if (oldIndex === newIndex) return;
    setDataCallback((data) => {
      const variations = data.product.variable_type.variations;
      variations.splice(newIndex, 0, variations.splice(oldIndex, 1)[0]);
    });
    setHasUnsavedChanges(true);
  };
  const handleSaveChanges = async (shouldFetchVariations = true) => {
    setIsSavingChanges(true);
    clearErrors();
    try {
      await variationsHttp.postSaveChanges({
        variations: variations.map((variation) => ({
          ..._.omit(variation, ["has_discount", "attributes"]),
          ...(variation.has_discount
            ? {}
            : {
                discounted_price: null,
                discount_expire: null,
              }),
          attributes: variation.attributes.reduce((acc, current) => ((acc[current.attribute_id] = current.attribute_value_id), acc), {}),
        })),
      });
      setHasUnsavedChanges(false);
      setIsSavingChanges(false);
      shouldFetchVariations && fetchVariations();
      return true;
    } catch (err) {
      handleHttpError(err, {
        onBeforeDefaultAction: () => setIsSavingChanges(false),
      });
    }
  };
  const fetchVariations = async () => {
    toggleLoader(true);
    try {
      const {
        data: { variations },
      } = await variationsHttp.getVariations(data.product.id);
      setDataCallback((data) => (data.product.variable_type.variations = variations));
      setVariationsFetchChange({});
      setHasUnsavedChanges(false);
      toggleLoader(false);
    } catch (err) {
      handleHttpError(err, {
        onBeforeDefaultAction: () => toggleLoader(false),
      });
    }
  };
  useEffect(() => {
    if (_Global.get("shouldRefetchVariations") && data.product.variable_type.attributes.length) {
      fetchVariations();
    }
  }, []);
  useDependencyChangeEffect(() => setVariations(getStateVariations()), [variationsFetchChange, data.productMainCategoryChange]);
  useDependencyChangeEffect(() => {
    if (!variations.length) {
      setHasUnsavedChanges(false);
    }
  }, [variations.length]);
  return (
    <VariationsTabContext.Provider
      value={{
        getVariationForState,
        handleSaveChanges,
        fetchVariations,
        variations,
        variationsFetchChange,
        errors,
        setVariations,
        updateVariations,
        hasUnsavedChanges,
        setHasUnsavedChanges,
      }}
    >
      {data.product.variable_type.attributes.length ? (
        <>
          <div className="d-flex align-items-center justify-content-between">
            <Actions />
            {hasUnsavedChanges && (
              <button className="btn btn-sm btn-warning ms-3" onClick={handleSaveChanges}>
                {isSavingChanges ? <span className="spinner-border spinner-border-sm"></span> : "ذخیره تغییرات"}
              </button>
            )}
          </div>
          {variations.length ? <SortableList variations={variations} onSortEnd={handleVariationsSortEnd} useDragHandle /> : <div className="alert alert-primary mb-0 mt-5">در حال حاظر متغیری وجود ندارد</div>}
        </>
      ) : (
        <div className="alert alert-primary mb-0">
          برای محصول متغیر حداقل یک خصوصیت الزامی است
          <button className="btn btn-sm btn-success ms-3" onClick={() => setActiveTab("AttributesTab")}>
            افزودن
          </button>
        </div>
      )}
    </VariationsTabContext.Provider>
  );
}
