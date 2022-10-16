import React from "react";

import * as _String from "$utilities/string";
import QuickviewBtn from "$components/shared/QuickviewBtn";

export default function ProductCard({ product }) {
  const selectedSu = product.selected_su;
  const isInStock = selectedSu.stock !== 0;
  return (
    <div className="product-card">
      <QuickviewBtn productId={product.id} />
      <div className="product-card__image">
        <a href={`/product/${product.id}`}>
          <img src={product.image.url} alt={product.name} />
        </a>
      </div>
      <div className="product-card__info">
        <div className="product-card__name">
          <a href={`/product/${product.id}`}>{product.name}</a>
        </div>
      </div>
      <div className="product-card__actions">
        <div className="product-card__prices">
          {isInStock ? (
            selectedSu.discounted_price ? (
              <>
                <span className="product-card__new-price">{`${_String.getThousandSeparated(
                  selectedSu.discounted_price
                )} تومان`}</span>
                <span className="product-card__old-price mr-1">{`${_String.getThousandSeparated(
                  selectedSu.price
                )} تومان`}</span>
              </>
            ) : (
              `${_String.getThousandSeparated(selectedSu.price)} تومان`
            )
          ) : (
            "ناموجود"
          )}
        </div>
        <div className="product-card__buttons">
          <div className="d-flex justify-content-end m-0 w-100">
            <a
              href={`/favourite/product/${product.id}`}
              className="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist"
              style={{ fill: product.is_user_favourite ? "red" : "" }}
            >
              <svg width="16px" height="16px">
                <use xlinkHref="/public/main/images/sprite.svg#wishlist-16"></use>
              </svg>
              <span className="fake-svg-icon fake-svg-icon--wishlist-16" />
            </a>
            <a
              href={`/compare/${product.id}`}
              className="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare"
            >
              <svg width="16px" height="16px">
                <use xlinkHref="/public/main/images/sprite.svg#compare-16" />
              </svg>
              <span className="fake-svg-icon fake-svg-icon--compare-16" />
            </a>
          </div>
        </div>
      </div>
    </div>
  );
}
