import React, { useMemo, useContext } from "react";

import ProductsSearchContext from "$contexts/partials/ProductsSearch";

export default function Body({ property }) {
  const { query, hasQueryState, toggleSearchQuery } = useContext(ProductsSearchContext);
  const values = useMemo(
    () =>
      property.pivot.values.map((value, idx) => {
        const queryParam = `properties[${property.id}][${idx}]`;

        return (
          <label className="filter-list__item" key={value.id}>
            <span className="filter-list__input input-check">
              <span className="input-check__body">
                <input className="input-check__input" type="checkbox" checked={hasQueryState(queryParam, value.id)} onChange={() => toggleSearchQuery(queryParam, value.id)} />
                <span className="input-check__box"></span>
                <svg className="input-check__icon" width="9px" height="7px">
                  <use xlinkHref="/public/main/images/sprite.svg#check-9x7"></use>
                </svg>
              </span>
            </span>
            <span className="filter-list__title">{value.value}</span>
          </label>
        );
      }),
    [query]
  );
  return (
    <div className="filter-list">
      <div className="filter-list__list">{values}</div>
    </div>
  );
}
