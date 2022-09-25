import React from "react";

import BaseSidebar from "$components/partials/ProductsSearch/PageContent/Sidebar";
import BrandFilterWidget from "$components/partials/ProductsSearch/PageContent/Sidebar/Widgets/BrandFilter";
import PriceFilterWidget from "$components/partials/ProductsSearch/PageContent/Sidebar/Widgets/PriceFilter";
import MiscFilterWidget from "$components/partials/ProductsSearch/PageContent/Sidebar/Widgets/MiscFilter";
import CategoryHierarchyWidget from "./Widgets/CategoryHierarchy";

const brands = _getData("pageData.brands");

export default function Sidebar() {
  return <BaseSidebar widgets={[<CategoryHierarchyWidget key={0} />, brands.length ? <BrandFilterWidget brands={brands} key={1} /> : null, <PriceFilterWidget key={2} />, <MiscFilterWidget key={3} />]} />;
}
