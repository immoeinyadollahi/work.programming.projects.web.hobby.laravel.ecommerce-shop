import React, { useMemo, useContext } from "react";

import ProductsSearchContext from "$contexts/partials/ProductsSearch";

export default function Body({ brands }) {
  const { query, hasQueryState, toggleSearchQuery } = useContext(ProductsSearchContext);
  const brandItems = useMemo(
    () =>
      brands.map((brand, idx) => {
        const queryParam = `brands[${idx}]`;

        return (
          <label className="filter-list__item" key={brand.id}>
            <span className="filter-list__input input-check">
              <span className="input-check__body">
                <input className="input-check__input" type="checkbox" checked={hasQueryState(queryParam, brand.id)} onChange={() => toggleSearchQuery(queryParam, brand.id)} />
                <span className="input-check__box"></span>
                <svg className="input-check__icon" width="9px" height="7px">
                  <use xlinkHref="/public/main/images/sprite.svg#check-9x7"></use>
                </svg>
              </span>
            </span>
            <span className="filter-list__title">{brand.fa}</span>
            {brand.en}
          </label>
        );
      }),
    [query]
  );
  return (
    <div className="filter-list">
      <div className="filter-list__list">{brandItems}</div>
    </div>
  );
}
