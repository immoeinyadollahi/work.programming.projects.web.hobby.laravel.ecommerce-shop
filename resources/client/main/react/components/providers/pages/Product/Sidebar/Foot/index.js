import React from "react";
import { Tooltip, OverlayTrigger } from "react-bootstrap";

import * as _String from "$utilities/string";
import { useState } from "$hooks/core/state";
import { useDependencyChangeEffect } from "$hooks/core/lifecycle";

export default function Foot({ su, product }) {
  const [quantity, setQuantity] = useState(1);
  useDependencyChangeEffect(() => setQuantity(1), [su]);
  return (
    <>
      <div className="mt-5">
        {su.discounted_price !== null && (
          <div className="d-flex align-items-center">
            <del className="text-muted ml-2">{_String.getThousandSeparated(su.price)} تومان</del>
            <span className="badge badge-danger badge-pill rounded">{su.discount_percent}%</span>
          </div>
        )}
        <div className="product__prices m-0">{_String.getThousandSeparated(su.sale_price)} تومان</div>
      </div>
      <div className="form-group product__option">
        <label className="product__option-label" htmlFor="product-quantity">
          تعداد
        </label>
        <div className="product__actions">
          <div className="product__actions-item">
            <div className="input-number product__quantity">
              <input id="product-quantity" className="input-number__input form-control form-control-lg" type="number" value={quantity} onChange={() => {}} />
              <div className="input-number__add" onClick={() => setQuantity(quantity + 1)} />
              <div className="input-number__sub" onClick={() => quantity !== 1 && setQuantity(quantity - 1)} />
            </div>
          </div>
          <div className="product__actions-item product__actions-item--addtocart">
            <button className="btn btn-primary btn-lg" onClick={() => (location.href = `/cart/add/${su.id}/${quantity}`)}>
              افزودن به سبد
            </button>
          </div>
        </div>
      </div>
    </>
  );
}
