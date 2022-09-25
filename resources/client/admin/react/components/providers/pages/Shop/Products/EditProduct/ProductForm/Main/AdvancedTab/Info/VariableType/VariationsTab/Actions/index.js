import React, { useContext } from "react";

import * as variationsHttp from "$http/shop/products/variable-type/variations";
import VariationsTabContext from "$contexts/pages/Shop/ProductEdit/VariableType/VariationsTab";
import { useState } from "$hooks/core/state";
import { useDependencyChangeEffect } from "$hooks/core/lifecycle";
import useData from "$hooks/actions/useData";
import useErrorHandler from "$hooks/common/useErrorHandler";
import SaveChangesConfirmModal from "./SaveChangesConfirmModal";

export default function Actions() {
    const { data, setDataCallback } = useData();
    const [isPeformingAction, setIsPeformingAction] = useState(false);
    const [
        isSaveChangesConfirmModalActive,
        setIsSaveChangesConfirmModalActive,
    ] = useState(false);
    const [selectedAction, setSelectedAction] = useState("create-variation");
    const { handleHttpError } = useErrorHandler();
    const {
        variations,
        getVariationForState,
        setVariations,
        hasUnsavedChanges,
        handleSaveChanges,
        fetchVariations,
    } = useContext(VariationsTabContext);
    const createVariationsFromAttributesCtrl = {
        async onSaveChangesConfirm() {
            if (await handleSaveChanges(false)) this.doAction();
        },
        onSaveChangesDeny() {
            this.doAction();
        },
        async doAction() {
            try {
                setIsPeformingAction(true);
                const { data: result } = await variationsHttp.getPerformAction(
                    data.product.id,
                    selectedAction
                );
                setIsPeformingAction(false);
                alert(`${result.new_variations_count} متغیر جدید اضافه شد`);
                fetchVariations();
            } catch (err) {
                handleHttpError(err, {
                    onBeforeDefaultAction: () => setIsPeformingAction(false),
                });
            }
        },
    };
    const actions = {
        async "create-variation"() {
            try {
                setIsPeformingAction(true);
                const { data: result } = await variationsHttp.getPerformAction(
                    data.product.id,
                    selectedAction
                );
                setDataCallback((data) =>
                    data.product.variable_type.variations.push(result.variation)
                );
                setVariations(
                    variations.concat(getVariationForState(result.variation))
                );
                setIsPeformingAction(false);
            } catch (err) {
                handleHttpError(err, {
                    onBeforeDefaultAction: () => setIsPeformingAction(false),
                });
            }
        },
        async "create-variations-from-attributes"() {
            if (hasUnsavedChanges) {
                setIsSaveChangesConfirmModalActive(true);
            } else {
                createVariationsFromAttributesCtrl.doAction();
            }
        },
        async "remove-all-variations"() {
            try {
                setIsPeformingAction(true);
                await variationsHttp.getPerformAction(
                    data.product.id,
                    selectedAction
                );
                setDataCallback(
                    (data) => (data.product.variable_type.variations = [])
                );
                setVariations([]);
                setIsPeformingAction(false);
            } catch (err) {
                handleHttpError(err, {
                    onBeforeDefaultAction: () => setIsPeformingAction(false),
                });
            }
        },
    };
    useDependencyChangeEffect(() => {
        if (
            !variations.length &&
            !["create-variation", "create-variations-from-attributes"].includes(
                selectedAction
            )
        ) {
            setSelectedAction("create-variation");
        }
    }, [variations.length]);
    return (
        <>
            <div className="d-flex align-items-center">
                <select
                    className="form-select me-4 ms-2 min-w-100px"
                    value={selectedAction}
                    onChange={(e) => setSelectedAction(e.target.value)}
                >
                    <option value="create-variation">افزودن متغیر</option>
                    <option value="create-variations-from-attributes">
                        ساختن متغیر ها از همه ویژگی ها
                    </option>
                    {variations.length ? (
                        <option value="remove-all-variations">
                            حذف همه متغیر ها
                        </option>
                    ) : null}
                </select>
                <button
                    className="btn btn-primary"
                    onClick={() => actions[selectedAction]()}
                >
                    {isPeformingAction ? (
                        <span className="spinner-border spinner-border-sm"></span>
                    ) : (
                        " اعمال"
                    )}
                </button>
            </div>
            {isSaveChangesConfirmModalActive && (
                <SaveChangesConfirmModal
                    onClose={() => setIsSaveChangesConfirmModalActive(false)}
                    onConfirm={() =>
                        createVariationsFromAttributesCtrl.onSaveChangesConfirm()
                    }
                    onDeny={() =>
                        createVariationsFromAttributesCtrl.onSaveChangesDeny()
                    }
                />
            )}
        </>
    );
}
