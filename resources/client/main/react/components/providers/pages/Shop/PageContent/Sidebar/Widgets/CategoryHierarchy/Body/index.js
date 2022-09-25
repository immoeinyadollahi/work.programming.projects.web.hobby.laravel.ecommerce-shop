import React from "react";

const category = _getData("pageData.category");

export default function Body() {
  return (
    <div className="filter-categories">
      <ul className="filter-categories__list">
        {category.parents.length ? (
          <div className="filter-categories--parents">
            {category.parents.map((category, idx) => (
              <li className="filter-categories__item filter-categories__item--parent" style={{ paddingRight: idx * 15 }} key={category.id}>
                <svg className="filter-categories__arrow" width="6px" height="9px">
                  <use xlinkHref="/public/main/images/sprite.svg#arrow-rounded-left-6x9"></use>
                </svg>
                <a href={`/shop/${category.slug}`}>{category.fa}</a>
              </li>
            ))}
          </div>
        ) : null}
        <li className="filter-categories__item filter-categories__item--current" style={{ paddingRight: category.parents.length * 15 }}>
          <a href={`/shop/${category.slug}`}>{category.fa}</a>
        </li>
        {category.children.length ? (
          <div className="filter-categories--children" style={{ paddingRight: category.parents.length * 15 + 15 }}>
            {category.children.map((category) => (
              <li className="filter-categories__item filter-categories__item--child" key={category.id}>
                <a href={`/shop/${category.slug}`}>{category.fa}</a>
              </li>
            ))}
          </div>
        ) : null}
      </ul>
    </div>
  );
}
