import React, { useContext } from "react";

import ProductsSearchContext from "$contexts/partials/ProductsSearch";

const categories = _getData("pageData.categories");

export default function Body() {
  const { query } = useContext(ProductsSearchContext);

  return (
    <div className="filter-categories">
      <ul className="filter-categories__list">
        {categories.map((category) => (
          <li className="filter-categories__item" key={category.id}>
            <svg className="filter-categories__arrow" width="6px" height="9px">
              <use xlinkHref="/public/main/images/sprite.svg#arrow-rounded-left-6x9"></use>
            </svg>
            <a href={`/shop/${category.slug}${query.q || query.tag ? `?${query.q ? `q=${query.q}` : ""}${query.q && query.tag ? "&" : ""}${query.tag ? `tag=${query.tag}` : ""}` : ""}`}>{category.fa}</a>
          </li>
        ))}
      </ul>
    </div>
  );
}
