import React from "react";
import { SortableHandle } from "react-sortable-hoc-rtl";
import _ from "lodash";

import * as slideshowHttp from "$http/settings/slideshow";
import { useState } from "$hooks/core/state";
import DeleteItemConfirmModal from "$components/shared/DeleteItemConfirmModal";
import EditModal from "./EditModal";

const SortableDragHandle = SortableHandle(() => <span className="far fa-arrows cursor-move c-list-item-action"></span>);

export default function Slide({ slide, updateSlideshow, counter }) {
  const [isDeleteConfirmModalActive, setIsDeleteConfirmModalActive] = useState(false);
  const [isEditModalActive, setIsEditModalActive] = useState(false);
  const handleUpdateSlide = (newData) => {
    updateSlideshow((state) =>
      Object.assign(
        state.slides.find((stateSlide) => stateSlide.id === slide.id),
        newData
      )
    );
  };
  const handleDeleteSlide = () => {
    updateSlideshow((state) => (state.slides = state.slides.filter((stateSlide) => stateSlide.id !== slide.id)));
  };
  return (
    <>
      <div className="d-flex align-items-center p-3">
        <input type="hidden" name={`slideshow[slides][${counter - 1}]`} value={slide.id} />
        <div className="d-flex align-items-center flex-grow-1">
          <span className="badge badge-circle badge-secondary me-3">{counter}</span>
          <div className="d-flex align-items-center">
            <span className="fw-bold me-2">عنوان :</span>
            {slide.title}
          </div>
          <span className="vr mx-3"></span>
          <div className="d-flex align-items-center">
            <a href={slide.images.desktop.url} className="btn btn-sm btn-success me-3">
              تصویر دسکتاپ
            </a>
            <a href={slide.images.mobile.url} className="btn btn-sm btn-warning">
              تصویر موبایل
            </a>
          </div>
        </div>
        <div className="d-flex align-items-center">
          <SortableDragHandle />
          <span className="fas fa-pen text-warning c-list-item-action" onClick={() => setIsEditModalActive(true)}></span>
          <span className="fas fa-trash text-danger c-list-item-action" onClick={() => setIsDeleteConfirmModalActive(true)}></span>
        </div>
      </div>
      {isEditModalActive && <EditModal onClose={() => setIsEditModalActive(false)} onSubmit={handleUpdateSlide} slide={slide} />}
      {isDeleteConfirmModalActive && <DeleteItemConfirmModal onClose={() => setIsDeleteConfirmModalActive(false)} onConfirm={handleDeleteSlide} onRequest={() => slideshowHttp.deleteSlide(slide.id)} title="حذف اسلاید" />}
    </>
  );
}
