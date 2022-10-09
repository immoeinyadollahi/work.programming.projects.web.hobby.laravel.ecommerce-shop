import React from "react";

import BaseSidebar from "$components/partials/ProductsSearch/PageContent/Sidebar";
import BrandFilterWidget from "$components/partials/ProductsSearch/PageContent/Sidebar/Widgets/BrandFilter";
import PriceFilterWidget from "$components/partials/ProductsSearch/PageContent/Sidebar/Widgets/PriceFilter";
import MiscFilterWidget from "$components/partials/ProductsSearch/PageContent/Sidebar/Widgets/MiscFilter";
import CategoryHierarchyWidget from "./Widgets/CategoryHierarchy";
import PropertyFilterWidget from "./Widgets/PropertyFilter";
import AttributeFilterWidget from "./Widgets/AttributeFilter";

const category = _getData("pageData.category");

export default function Sidebar() {
  return (
    <BaseSidebar
      widgets={[
        <CategoryHierarchyWidget key={0} />,
        category.brands.length ? <BrandFilterWidget brands={category.brands} key={1} /> : null,
        <PriceFilterWidget key={2} />,
        <MiscFilterWidget key={3} />,
        category.properties.length ? category.properties.map((property) => <PropertyFilterWidget property={property} key={`4-${property.id}`} />) : null,
        category.attributes.length ? category.attributes.map((attribute) => <AttributeFilterWidget attribute={attribute} key={`5-${attribute.id}`} />) : null,
      ]}
    />
  );
}
