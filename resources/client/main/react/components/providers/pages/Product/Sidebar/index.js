import React from "react";

import VariableType from "./VariableType";
import Foot from "./Foot";

const product = _getData("pageData.product");

export default function Sidebar() {
  return product.selected_su.stock ? (
    <>
      <div className="product__availability mb-3">
        موجودی: <span className="text-success">موجود در انبار</span>
      </div>
      {/* .product__options */}
      <div className="product__options">{product.type === "variable" ? <VariableType product={product} /> : <Foot su={product.selected_su} product={product} />}</div>
      {/* .product__options / end */}
    </>
  ) : (
    <div className="product__availability">
      موجودی: <span className="text-danger">ناموجود</span>
    </div>
  );
}
