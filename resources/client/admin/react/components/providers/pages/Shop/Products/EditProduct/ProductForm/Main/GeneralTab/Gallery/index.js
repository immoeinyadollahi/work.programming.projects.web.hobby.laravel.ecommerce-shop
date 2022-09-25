import React, { useContext } from "react";
import { SortableContainer, SortableElement } from "react-sortable-hoc-rtl";

import ProductContext from "$contexts/pages/Shop/ProductEdit";
import { useState } from "$hooks/core/state";
import UploadModal from "./UploadModal";
import Thumbnail from "./Thumbnail";

const SortableItem = SortableElement(Thumbnail);
const SortableList = SortableContainer(({ thumbnails, isSorting }) => {
  return (
    <div>
      <div className={`d-flex flex-wrap product-gallery-thumbnails-list${isSorting ? " sorting" : ""}`}>
        {thumbnails.map((thumbnail, idx) => (
          <SortableItem key={thumbnail.id} thumbnail={thumbnail} index={idx} />
        ))}
      </div>
    </div>
  );
});

export default function Gallery() {
  const [isUploadModalActive, setIsUploadModalActive] = useState(false);
  const [isSortingThumbnails, setIsSortingThumbnails] = useState(false);
  const { productState, updateProductState } = useContext(ProductContext);

  const handleSaveUploadedThumbnails = (thumbnails) => {
    if (thumbnails.length) {
      updateProductState((state) => state.thumbnails.push(...thumbnails));
    }
  };
  const handleThumbnailsSortEnd = ({ oldIndex, newIndex }) => {
    setIsSortingThumbnails(false);
    if (oldIndex === newIndex) return;
    updateProductState((state) => {
      state.thumbnails.splice(newIndex, 0, state.thumbnails.splice(oldIndex, 1)[0]);
    });
  };
  return (
    <>
      <div className="card card-flush card-widget">
        {/*begin::Card header*/}
        <div className="card-header">
          <div className="card-title">
            <h2>گالری</h2>
          </div>
          <button className="btn btn-primary" onClick={() => setIsUploadModalActive(true)}>
            افزودن
          </button>
        </div>
        {/*end::Card header*/}
        {/*begin::Card body*/}
        <div className="card-body">
          {productState.thumbnails.length ? (
            <SortableList thumbnails={productState.thumbnails} isSorting={isSortingThumbnails} onSortStart={() => setIsSortingThumbnails(true)} onSortEnd={handleThumbnailsSortEnd} axis="x" rtl />
          ) : (
            <div className="alert alert-primary mb-0">
              در حال حاظر تصویری برای گالری وجود ندارد
              <button className="btn btn-sm btn-success ms-3" onClick={() => setIsUploadModalActive(true)}>
                افزودن
              </button>
            </div>
          )}
        </div>
        {/*end::Card body*/}
      </div>
      {isUploadModalActive && <UploadModal onClose={() => setIsUploadModalActive(false)} onSave={handleSaveUploadedThumbnails} />}
    </>
  );
}
