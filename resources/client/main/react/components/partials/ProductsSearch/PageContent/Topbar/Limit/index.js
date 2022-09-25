import React, { useContext, useMemo } from "react";

import ProductsSearchContext from "$contexts/partials/ProductsSearch";

const limitOptions = ["18", "27", "36"];

export default function Limit() {
  const { query, setSearchQuery } = useContext(ProductsSearchContext);
  const queryLimit = useMemo(() => (query.limit && limitOptions.includes(query.limit) ? query.limit : "18"), [query.sort]);
  return (
    <div className="view-options__control">
      <label>تعداد نمایش</label>
      <div>
        <select className="form-control form-control-sm" value={queryLimit} onChange={(e) => setSearchQuery({ limit: e.target.value, page: 1 })}>
          {limitOptions.map((option) => (
            <option value={option} key={option}>
              {option}
            </option>
          ))}
        </select>
      </div>
    </div>
  );
}
