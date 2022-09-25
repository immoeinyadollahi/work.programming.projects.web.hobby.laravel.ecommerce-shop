import React, { useContext } from "react";

import ProductsSearchContext from "$contexts/partials/ProductsSearch";
import Widget from "../../Widget";

export default function MiscFilter() {
  const { hasQueryState, toggleSearchQuery } = useContext(ProductsSearchContext);
  return (
    <Widget>
      <div className="filter-list">
        <div className="filter-list__list">
          <label className="filter-list__item">
            <span className="filter-list__input input-check">
              <span className="input-check__body">
                <input className="input-check__input" checked={hasQueryState("only_available", "1")} type="checkbox" onChange={(e) => toggleSearchQuery("only_available", "1")} />
                <span className="input-check__box"></span>
                <svg className="input-check__icon" width="9px" height="7px">
                  <use xlinkHref="/public/main/images/sprite.svg#check-9x7"></use>
                </svg>
              </span>
            </span>
            <span className="filter-list__title">فقط کالاهای موجود</span>
          </label>
          <label className="filter-list__item">
            <span className="filter-list__input input-check">
              <span className="input-check__body">
                <input className="input-check__input" checked={hasQueryState("only_discounted", "1")} type="checkbox" onChange={(e) => toggleSearchQuery("only_discounted", "1")} />
                <span className="input-check__box"></span>
                <svg className="input-check__icon" width="9px" height="7px">
                  <use xlinkHref="/public/main/images/sprite.svg#check-9x7"></use>
                </svg>
              </span>
            </span>
            <span className="filter-list__title">فقط کالاهای تخفیف دار</span>
          </label>
        </div>
      </div>
    </Widget>
  );
}
