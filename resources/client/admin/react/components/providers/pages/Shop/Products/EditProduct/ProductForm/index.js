import React, { useMemo } from "react";
import _ from "lodash";

import ProductContext from "$contexts/pages/Shop/ProductEdit";
import useData from "$hooks/actions/useData";
import { useState } from "$hooks/core/state";
import Main from "./Main";
import Sidebar from "./Sidebar";

export default function ProductForm() {
  const { data } = useData();
  const product = data.product;
  const initialState = useMemo(() => ({
    name: product.name,
    description: product.description,
    status: product.status,
    brand: product.brand,
    image: product.image && _.pick(product.image, ["id", "url"]),
    thumbnails: product.thumbnails.map((thumbnail) => _.pick(thumbnail, ["id", "url"])),
  }));
  const [errors, setErrors] = useState();
  const [productState, , updateProductState, setProductStateKeyValue] = useState(initialState);
  return (
    <ProductContext.Provider
      value={{
        productState,
        updateProductState,
        setProductStateKeyValue,
        setErrors,
      }}
    >
      <Sidebar />
      <Main />
    </ProductContext.Provider>
  );
}
