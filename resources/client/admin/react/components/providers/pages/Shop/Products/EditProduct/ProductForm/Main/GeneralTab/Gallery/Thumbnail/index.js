import React, { useContext } from "react";

import ProductContext from "$contexts/pages/Shop/ProductEdit";

export default function Thumbnail({ thumbnail }) {
  const { updateProductState } = useContext(ProductContext);
  const handleRemoveThumbnail = () => updateProductState((state) => (state.thumbnails = state.thumbnails.filter((thumb) => thumb.id !== thumbnail.id)));
  return (
    <div className="product-gallery-thumbnail">
      <div className="overlay">
        <button className="btn btn-danger btn-sm" onClick={handleRemoveThumbnail}>
          <span className="far fa-trash"></span>
        </button>
      </div>
      <img src={thumbnail.url} alt="تصویر گالری" />
    </div>
  );
}
