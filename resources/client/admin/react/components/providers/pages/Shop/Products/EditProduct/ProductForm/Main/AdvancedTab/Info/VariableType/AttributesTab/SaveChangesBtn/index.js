import React from "react";

import * as attributesHttp from "$http/shop/products/variable-type/attributes";
import { useState } from "$hooks/core/state";
import useErrorHandler from "$hooks/common/useErrorHandler";

export default function SaveChangesBtn({
    onSave,
    attributesOrdering,
    product,
}) {
    const [isSaving, setIsSaving] = useState(false);
    const { handleHttpError } = useErrorHandler();

    const handleSaveChanges = async () => {
        setIsSaving(true);
        try {
            await attributesHttp.postSaveOrdering(product.id, {
                attributes: attributesOrdering,
            });
            onSave();
        } catch (err) {
            handleHttpError(err, {
                onBeforeDefaultAction: () => setIsSaving(false),
            });
        }
    };
    return (
        <button
            className="btn btn-sm btn-warning ms-3"
            onClick={handleSaveChanges}
        >
            {isSaving ? (
                <span className="spinner-border spinner-border-sm"></span>
            ) : (
                "ذخیره تغییرات"
            )}
        </button>
    );
}
