import { useMemo } from "react";
import _ from "lodash";

import * as _History from "$utilities/history";
import { useState } from "$hooks/core/state";

export default function useQuery({ defaultQuery = {}, excludeSearchParams = [], excludeClearParams = [] }) {
  const [initialQueryState, initialSearchParams] = useMemo(() => {
    const initialSearchParams = new URLSearchParams(location.search);

    const initialQueryState = { ...defaultQuery };
    initialSearchParams.forEach((value, key) => {
      if (!excludeSearchParams.includes(key)) {
        initialQueryState[key] = value;
      }
    });
    return [initialQueryState, initialSearchParams];
  }, []);

  const [query, setQuery] = useState(initialQueryState);
  const [queryChange, setQueryChange] = useState();
  const navigateTo = (searchParams) => {
    const queryString = searchParams.toString();
    _History.navigate(`${location.pathname}${queryString ? `?${queryString}` : ""}`);
  };
  const getQuerySearchParams = (useParamExclusion = false) => {
    return getSearchParamsFromObject(query, useParamExclusion);
  };
  const getSearchParamsFromObject = (obj, useParamExclusion = false) => {
    const searchParams = new URLSearchParams();
    _.forOwn(obj, (value, key) => {
      if (useParamExclusion) {
        if (!excludeSearchParams.includes(key)) {
          searchParams.append(key, value);
        }
      } else {
        searchParams.append(key, value);
      }
    });
    return searchParams;
  };
  const getSearchQueryString = (useParamExclusion) => {
    return getQuerySearchParams(useParamExclusion).toString();
  };
  const applySearchQueryString = () => {
    navigateTo(getQuerySearchParams(true));
    setQueryChange({});
  };
  const hasQueryState = (key, value) => {
    value = value.toString();
    const queryValue = query[key];
    return value ? Boolean(queryValue) && queryValue === value : Boolean(queryValue);
  };
  const excludeFromQueryState = (keys, { queryChange = true }) => {
    setQuery(_.omit(query, keys));
    if (queryChange) {
      setQueryChange({});
    }
  };
  // Clear
  const clearSearchQuery = ({ queryChange = true, historyChange = true } = {}) => {
    const excludedQueryParams = _.pick(query, excludeClearParams);
    setQuery(excludedQueryParams);
    if (historyChange) {
      navigateTo(getSearchParamsFromObject(excludedQueryParams, true));
    }
    if (queryChange) {
      setQueryChange({});
    }
  };
  // Toggle
  const toggleSearchQuery = (key, value, { queryChange = true, historyChange = true } = {}) => {
    const newQuery = { ...query };
    if (newQuery[key]) {
      delete newQuery[key];
    } else {
      newQuery[key] = value.toString();
    }
    setQuery(newQuery);
    if (historyChange) {
      navigateTo(getSearchParamsFromObject(newQuery, true));
    }
    if (queryChange) {
      setQueryChange({});
    }
  };
  // Set
  const setSearchQuery = (params, { queryChange = true, historyChange = true } = {}) => {
    const newQuery = Object.entries(params).reduce((acc, current) => ((acc[current[0]] = current[1].toString()), acc), { ...query });
    setQuery(newQuery);
    if (historyChange) {
      navigateTo(getSearchParamsFromObject(newQuery, true));
    }
    if (queryChange) {
      setQueryChange({});
    }
  };
  return {
    query,
    setQuery,
    queryChange,
    setQueryChange,
    initialSearchParams,
    queryDeps: [location.search, query],
    hasQueryState,
    getQuerySearchParams,
    getSearchQueryString,
    applySearchQueryString,
    excludeFromQueryState,
    clearSearchQuery,
    toggleSearchQuery,
    setSearchQuery,
  };
}
