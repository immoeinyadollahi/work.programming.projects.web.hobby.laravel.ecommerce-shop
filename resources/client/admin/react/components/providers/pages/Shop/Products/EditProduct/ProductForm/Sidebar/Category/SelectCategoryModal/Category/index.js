import React, { useMemo } from "react";

import { useState } from "$hooks/core/state";

export default function Category({ category, productCategories, selectedCategory, setSelectedCategory }) {
  const isChildrenBodyInitiallyExpanded = useMemo(() => (productCategories.length ? productCategories.some((productCategory) => productCategory.id === category.id) : false), []);
  const [isChildrenBodyExpanded, setIsChildrenBodyExpanded] = useState(isChildrenBodyInitiallyExpanded);
  return (
    <div className="category-wrap">
      {category.children.length ? (
        <>
          <div className="category-head" onClick={() => setIsChildrenBodyExpanded(!isChildrenBodyExpanded)}>
            <span className="category-head-title">{category.fa}</span>
            <span className={`category-head-arrow fas fa-angle-${isChildrenBodyExpanded ? "up" : "down"}`}></span>
          </div>
          <div className="category-children" style={{ display: isChildrenBodyExpanded ? "block" : "none" }}>
            {category.children.map((category) => (
              <Category key={category.id} productCategories={productCategories} category={category} selectedCategory={selectedCategory} setSelectedCategory={setSelectedCategory} />
            ))}
          </div>
        </>
      ) : (
        <div className="form-check form-check-custom form-check-sm">
          <input id={`category-modal-item-${category.id}`} className="form-check-input" type="radio" checked={selectedCategory === category.id} onChange={() => setSelectedCategory(category.id)} />
          <label className="form-check-label" htmlFor={`category-modal-item-${category.id}`}>
            {category.fa}
          </label>
        </div>
      )}
    </div>
  );
}
