import React from "react";

import * as specificationsHttp from "$http/shop/products/specifications";
import { useState } from "$hooks/core/state";
import useErrorHandler from "$hooks/common/useErrorHandler";

export default function SaveChangesBtn({ onSave, specsOrdering }) {
    const [isSaving, setIsSaving] = useState(false);
    const { handleHttpError } = useErrorHandler();

    const handleSaveChanges = async () => {
        setIsSaving(true);
        try {
            await specificationsHttp.postSaveOrdering({
                groups: specsOrdering.map(({ groupId, itemIds }) => ({
                    id: groupId,
                    items: itemIds,
                })),
            });
            onSave();
        } catch (err) {
            handleHttpError(err, {
                onBeforeDefaultAction: () => setIsSubmiting(false),
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
