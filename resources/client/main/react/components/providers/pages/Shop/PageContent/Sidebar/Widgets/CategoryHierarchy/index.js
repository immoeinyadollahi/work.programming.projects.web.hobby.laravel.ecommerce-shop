import React from "react";

import Widget from "$components/partials/ProductsSearch/PageContent/Sidebar/Widget";
import Body from "./Body";

export default function CategoryHierarchy() {
  return (
    <Widget title="دسته بندی ها" defaultOpen>
      <Body />
    </Widget>
  );
}
