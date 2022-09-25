import React from "react";

import * as productsHttp from "$http/products";
import { useState } from "$hooks/core/state";
import useErrorHandler from "$hooks/common/useErrorHandler";
import ProductModal from "./ProductModal";

export default function Btn({ productId }) {
  const [productModalState, setProductModalState] = useState({});
  const [isFetchingProduct, setIsFetchingProduct] = useState(false);
  const { handleHttpError } = useErrorHandler();
  const fetchProduct = async () => {
    try {
      setIsFetchingProduct(true);
      const {
        data: { product },
      } = await productsHttp.getQuickviewProduct(productId);
      setProductModalState({ isActive: true, product });
      setIsFetchingProduct(false);
    } catch (err) {
      handleHttpError(err, {
        onBeforeDefaultAction: () => setIsFetchingProduct(false),
      });
    }
  };
  return (
    <>
      <button className={`product-card__quickview${isFetchingProduct ? " product-card__quickview--preload" : ""}`} onClick={() => isFetchingProduct || fetchProduct()}>
        <svg width="16px" height="16px">
          <use xlinkHref="/public/main/images/sprite.svg#quickview-16" />
        </svg>
        <span className="fake-svg-icon" />
      </button>
      {productModalState.isActive && <ProductModal onClose={() => setProductModalState({})} />}
    </>
  );
}
