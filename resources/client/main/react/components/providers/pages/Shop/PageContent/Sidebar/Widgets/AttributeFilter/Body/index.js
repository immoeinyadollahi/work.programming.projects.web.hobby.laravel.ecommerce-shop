import React, { useMemo, useContext } from "react";

import ProductsSearchContext from "$contexts/partials/ProductsSearch";

export default function Body({ attribute }) {
  const { query, hasQueryState, toggleSearchQuery } = useContext(ProductsSearchContext);
  const values = useMemo(
    () =>
      attribute.pivot.values.map((value, idx) => {
        let append;
        const queryParam = `attributes[${attribute.id}][${idx}]`;
        switch (attribute.en) {
          case "color":
            append = (
              <div
                className="color-attribute-style"
                style={{
                  backgroundColor: value.meta.code,
                }}
              ></div>
            );

            break;
          case "size":
            append = <div className="size-attribute-style">{value.en}</div>;
            break;
          default:
            break;
        }
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
            <span className="filter-list__title">{value.fa}</span>
            {append}
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
