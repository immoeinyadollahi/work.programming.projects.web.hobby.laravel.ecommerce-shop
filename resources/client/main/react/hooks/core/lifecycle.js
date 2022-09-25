import { useRef, useEffect, useMemo } from "react";

import { useState } from "./state";

export const useIsMounted = () => {
    const isMounted = useRef(false);
    useEffect(() => {
        isMounted.current = true;
        return () => (isMounted.current = false);
    }, []);
    return () => isMounted.current;
};
export const useDependencyChangeMemo = (onChange, deps, initialValue) => {
    const isMounted = useRef(false);
    return useMemo(() => {
        if (isMounted.current) {
            return onChange();
        }
        isMounted.current = true;
        return initialValue;
    }, deps);
};
export const useDependencyChangeEffect = (onChange, deps) => {
    const isMounted = useRef(false);
    useEffect(() => {
        if (isMounted.current) {
            const result = onChange();
            if (typeof result === "function") return result;
        }
        isMounted.current = true;
    }, deps);
};
export const useComponentWillMount = (cb) => {
    const willMount = useRef(true);
    if (willMount.current) cb();
    willMount.current = false;
    // or use useMemo(cb,[])
};
// no recommended for very deep dependencies
export const useFreshDependencies = (...deps) => {
    const dependenciesRef = useRef();
    useMemo(() => (dependenciesRef.current = deps), deps);
    return useMemo(
        () => deps.map((dep, idx) => () => dependenciesRef.current[idx]),
        []
    ); // or just use (idx)=>dependenciesRef.current[idx] also pass idx to this function when calling it
};
export const useUpdateWithFreshDependencies = (...deps) => {
    const getFreshDependenciesHandlers = useFreshDependencies(...deps);
    return useMemo(
        () =>
            deps.map(
                (dep, idx) => (cb) => cb(getFreshDependenciesHandlers[idx]())
            ),
        []
    );
};
export const useUpdateState = (...states) => {
    const callbackRef = useRef();
    const [stateChange, setStateChange] = useState();
    useDependencyChangeEffect(() => {
        callbackRef.current(...states);
        callbackRef.current = null;
    }, [stateChange]);
    return (cb) => {
        callbackRef.current = cb;
        setStateChange({});
    };
};
