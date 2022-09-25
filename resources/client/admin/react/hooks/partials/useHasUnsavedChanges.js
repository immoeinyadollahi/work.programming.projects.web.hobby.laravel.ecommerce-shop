import { useEffect } from "react";

import * as _Global from "$utilities/global";
import { useState } from "../core/state";

export default function useHasUnsavedChanges(key) {
    const [hasUnsavedChanges, setHasUnsavedChanges] = useState(false);
    key = `UnsavedChanges.${key}`;
    useEffect(() => {
        _Global.set(key, hasUnsavedChanges);
        return () => _Global.unset(key);
    }, [hasUnsavedChanges]);
    return [hasUnsavedChanges, setHasUnsavedChanges];
}
