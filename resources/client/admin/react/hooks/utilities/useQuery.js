import { useMemo } from "react";

import { useState } from "../core/state";

export default function useQuery({
    defaultQuery = {},
    excludeSearchParams = [],
    excludeClearParams = [],
}) {
    const location = "";
    const navigate = useNavigate();
    const initialSearchParams = useMemo(
        () => new URLSearchParams(location.search),
        []
    );
    const initialQuery = useMemo(() => {
        const result = {};
        initialSearchParams.forEach((value, key) => {
            if (!excludeSearchParams.includes(key)) {
                const resultValue = result[key];
                if (resultValue)
                    Array.isArray(resultValue)
                        ? resultValue.push(value)
                        : (result[key] = [resultValue, value]);
                else result[key] = value;
            }
        });
        return result;
    }, []);
    const initialQueryState = useMemo(
        () => ({
            ...defaultQuery,
            ...initialQuery,
        }),
        []
    );
    const [query, setQuery] = useState(initialQueryState);
    const [queryChange, setQueryChange] = useState();
    const getSearchQueryString = () => {
        const searchParams = new URLSearchParams();
        for (const param in query) {
            const value = query[param];
            Array.isArray(value)
                ? value.forEach((item) => searchParams.append(param, item))
                : searchParams.append(param, value);
        }
        return searchParams.toString();
    };
    const applySearchQueryString = () => {
        const searchParams = new URLSearchParams();
        for (const param in query) {
            if (!excludeSearchParams.includes(param)) {
                const value = query[param];
                Array.isArray(value)
                    ? value.forEach((item) => searchParams.append(param, item))
                    : searchParams.append(param, value);
            }
        }
        navigate(`${location.pathname}?${searchParams.toString()}`);
        setQueryChange({});
    };
    // if you are using input[0][] style for inputs name,because all names are unique,omit this and just check for its name in state for its existence
    const hasQueryState = (key, value) => {
        return value
            ? query[key]
                ? Array.isArray(query[key])
                    ? query[key].includes(value)
                    : query[key] === value
                : false
            : query[key];
    };
    const excludeFromQueryState = (keys, queryChange = true) => {
        setQuery(
            Object.fromEntries(
                Object.entries(query).filter(
                    ([key, value]) => !keys.includes(key)
                )
            )
        );
        queryChange && setQueryChange({});
    };
    // Clear
    const clearSearchQuery = () => {
        clearQueryState();
        clearSearchParams();
    };
    const clearQueryState = (queryChange = true) => {
        setQuery(
            Object.fromEntries(
                Object.entries(query).filter(([k, v]) =>
                    excludeClearParams.includes(k)
                )
            )
        );
        queryChange && setQueryChange({});
    };
    const clearSearchParams = () => {
        const searchParams = new URLSearchParams(location.search);
        searchParams.forEach(
            (v, k) => !excludeClearParams.includes(k) && searchParams.delete(k)
        );
        navigate(`${location.pathname}?${searchParams.toString()}`);
    };
    // Toggle
    // you can use check functions (below) as well for toggling state
    const toggleSearchQuery = (param, value) => {
        toggleQueryState(param, value);
        toggleSearchParams(param, value);
    };
    const toggleQueryState = (key, value, queryChange = true) => {
        const newQuery = { ...query };
        if (newQuery[key]) {
            delete newQuery[key];
        } else {
            newQuery[key] = value;
        }
        setQuery(newQuery);
        queryChange && setQueryChange({});
    };
    const toggleSearchParams = (param, value) => {
        const searchParams = new URLSearchParams(location.search);
        if (searchParams.has(param)) {
            searchParams.delete(param);
        } else {
            searchParams.set(param, value);
        }
        navigate(`${location.pathname}?${searchParams.toString()}`);
    };
    // Set
    const setSearchQuery = (params) => {
        setQueryState(params);
        setSearchParams(params);
    };
    const setQueryState = (params, queryChange = true) => {
        setQuery({ ...query, ...params });
        queryChange && setQueryChange({});
    };
    const setSearchParams = (params) => {
        const searchParams = new URLSearchParams(location.search);
        for (const param in params) {
            if (!excludeSearchParams.includes(param)) {
                searchParams.set(param, params[param]);
            }
        }
        navigate(`${location.pathname}?${searchParams.toString()}`);
    };
    // Check
    // if you are using input[0][] style for inputs name,because all names are unique,
    // you can use toggle and omit this functions and only use searchParams to toggle checks this is the only available option in php
    const checkSearchQuery = (param, value) => {
        checkQueryState(param, value);
        checkSearchParams(param, value);
    };
    const checkQueryState = (key, value, queryChange = true) => {
        const newQuery = { ...query };
        if (newQuery[key]) {
            if (newQuery[key] === value) {
                delete newQuery[key];
            } else if (Array.isArray(newQuery[key])) {
                if (newQuery[key].includes(value)) {
                    newQuery[key] = newQuery[key].filter(
                        (item) => item !== value
                    );
                    if (!newQuery[key].length) {
                        delete newQuery[key];
                    }
                } else {
                    newQuery[key] = [...newQuery[key], value];
                }
            } else {
                newQuery[key] = [newQuery[key], value];
            }
        } else {
            newQuery[key] = value;
        }
        setQuery(newQuery);
        queryChange && setQueryChange({});
    };
    const checkSearchParams = (param, value) => {
        let parts = location.search.slice(1).split("&");
        const element = `${param}=${value}`;
        if (parts.includes(element)) {
            parts = parts.filter((item) => item !== element);
        } else {
            parts.push(element);
        }
        navigate(`${location.pathname}?${parts.join("&")}`);
    };
    return {
        query,
        setQuery,
        queryChange,
        setQueryChange,
        initialSearchParams,
        queryDeps: [location.search, query],
        hasQueryState,
        getSearchQueryString,
        applySearchQueryString,
        excludeFromQueryState,
        clearSearchQuery,
        clearQueryState,
        clearSearchParams,
        setSearchQuery,
        setQueryState,
        setSearchParams,
        toggleSearchQuery,
        toggleQueryState,
        toggleSearchParams,
        checkSearchQuery,
        checkQueryState,
        checkSearchParams,
    };
}
