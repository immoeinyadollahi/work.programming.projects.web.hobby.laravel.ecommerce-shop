import React, { useMemo, useContext } from "react";

import ProductsSearchContext from "$contexts/partials/ProductsSearch";
import Widget from "$components/partials/ProductsSearch/PageContent/Sidebar/Widget";
import Body from "./Body";

export default function AttributeFilter({ attribute }) {
  const { hasQueryState } = useContext(ProductsSearchContext);
  const hasInitialFilter = useMemo(() => attribute.pivot.values.some((value, idx) => hasQueryState(`attributes[${attribute.id}][${idx}]`, value.id)), []);

  return (
    <Widget title={attribute.fa} defaultOpen={hasInitialFilter}>
      <Body attribute={attribute} />
    </Widget>
  );
}
