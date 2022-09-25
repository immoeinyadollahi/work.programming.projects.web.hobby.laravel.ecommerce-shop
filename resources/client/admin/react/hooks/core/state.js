import React from "react";
import immer from "immer";

import { useIsMounted } from "./lifecycle";

export const useState = (initialState) => {
    const [state, setState] = React.useState(initialState);
    const isMounted = useIsMounted();
    const updateState = (cb) => {
        setState(
            immer(state, (draft) => {
                cb(draft);
            })
        );
    };
    // only used for objects
    const setStateKeyValue = (key, value) => {
        setState({ ...state, [key]: value });
    };
    return [
        state,
        (value) => isMounted() && setState(value),
        updateState,
        setStateKeyValue,
    ];
};
