import React, { useContext, useMemo } from "react";

import ProductsSearchContext from "$contexts/partials/ProductsSearch";

const sortOptions = [
  {
    title: "مرتبط ترین",
    value: "most-relevant",
  },
  {
    title: "پربازدید ترین",
    value: "most-visited",
  },
  {
    title: "جدید ترین",
    value: "newest",
  },
  {
    title: "پرفروش ترین",
    value: "best-selling",
  },
  {
    title: "ارزان ترین",
    value: "lowest-price",
  },
  {
    title: "گران ترین",
    value: "highest-price",
  },
];

export default function Sort() {
  const { query, setSearchQuery } = useContext(ProductsSearchContext);
  const querySort = useMemo(() => (query.sort && sortOptions.some((option) => option.value === query.sort) ? query.sort : "most-visited"), [query.sort]);
  return (
    <div className="view-options__control">
      <label>مرتب‌ سازی</label>
      <div>
        <select className="form-control form-control-sm" value={querySort} onChange={(e) => setSearchQuery({ sort: e.target.value, page: 1 })}>
          {sortOptions.map((option) => (
            <option value={option.value} key={option.value}>
              {option.title}
            </option>
          ))}
        </select>
      </div>
    </div>
  );
}
