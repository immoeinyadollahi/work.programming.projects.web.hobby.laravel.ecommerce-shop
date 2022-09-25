import React, { useMemo, useContext } from "react";

import ProductsSearchContext from "$contexts/partials/ProductsSearch";
import Widget from "../../Widget";
import Body from "./Body";

export default function BrandFilterWidget({ brands }) {
  const { hasQueryState } = useContext(ProductsSearchContext);
  const hasInitialFilter = useMemo(() => brands.some((brand, idx) => hasQueryState(`brands[${idx}]`, brand.id)), []);

  return (
    <Widget title="برند" defaultOpen={hasInitialFilter}>
      <Body brands={brands} />
    </Widget>
  );
}
