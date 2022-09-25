import { useDispatch, useSelector } from "react-redux";

import { updateLoader } from "$slices/loader";
import * as _DOM from "$utilities/dom";

export default function useLoader() {
    const { loader } = useSelector((state) => state);
    const dispatch = useDispatch();

    const toggleLoader = (active) => {
        const isActive = active ?? !loader.isActive;
        _DOM.setScrollLock(isActive);
        dispatch(updateLoader({ ...loader, isActive }));
    };
    return {
        toggleLoader,
        loader,
    };
}
