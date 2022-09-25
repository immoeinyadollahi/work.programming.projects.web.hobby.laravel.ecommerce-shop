import React from "react";

import Widget from "../../Widget";

export default function PriceFilter() {
  return (
    <Widget title="محدوده قیمت">
      <div className="filter-price" data-min={5000} data-max={150000} data-from={25000} data-to={110000}>
        <div className="filter-price__slider" />
        <div className="filter-price__title">
          <span className="filter-price__min-value" /> تومان - <span className="filter-price__max-value" /> تومان
        </div>
      </div>
    </Widget>
  );
}
