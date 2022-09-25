import React, { useMemo, useContext } from "react";

import ProductsSearchContext from "$contexts/partials/ProductsSearch";
import Widget from "$components/partials/ProductsSearch/PageContent/Sidebar/Widget";
import Body from "./Body";

export default function PropertyFilter({ property }) {
  const { hasQueryState } = useContext(ProductsSearchContext);
  const hasInitialFilter = useMemo(() => property.pivot.values.some((value, idx) => hasQueryState(`properties[${property.id}][${idx}]`, value.id)), []);

  return (
    <Widget title={property.name} defaultOpen={hasInitialFilter}>
      <Body property={property} />
    </Widget>
  );
}
