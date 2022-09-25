import React from "react";
import { SortableContainer, SortableElement } from "react-sortable-hoc-rtl";

import { useState } from "$hooks/core/state";
import AddSlideModal from "./AddSlideModal";
import Slide from "./Slide";

const SortableItem = SortableElement(Slide);
const SortableList = SortableContainer(({ slides, updateSlideshow }) => {
  return (
    <div>
      {slides.map((slide, idx) => (
        <SortableItem key={slide.id} slide={slide} counter={idx + 1} index={idx} updateSlideshow={updateSlideshow} />
      ))}
    </div>
  );
});

const slideshowData = _getData("pageData.settings.slideshow");

export default function Slideshow() {
  const [slideshow, , updateSlideshow] = useState(slideshowData);
  const [isAddSlideModalActive, setIsAddSlideModalActive] = useState(false);

  const handleAddSlide = (slide) => {
    updateSlideshow((state) => state.slide.push(slide));
  };
  const handleSlidesSortEnd = ({ oldIndex, newIndex }) => {
    if (oldIndex === newIndex) return;
    updateSlideshow((state) => {
      state.slides.splice(newIndex, 0, state.slides.splice(oldIndex, 1)[0]);
    });
  };
  return (
    <>
      <div className="card card-flush card-widget">
        <div className="card-header">
          <div className="card-title">
            <h2>اسلایدشو</h2>
          </div>
          <button type="button" className="btn btn-primary" onClick={() => setIsAddSlideModalActive(true)}>
            افزودن اسلاید
          </button>
        </div>
        <div className="card-body">
          {slideshow.slides.length ? (
            <SortableList slides={slideshow.slides} onSortEnd={handleSlidesSortEnd} updateSlideshow={updateSlideshow} useDragHandle />
          ) : (
            <div className="alert alert-primary mb-0">
              در حال حاظر اسلایدی وجود ندارد
              <button type="button" className="btn btn-sm btn-success ms-3" onClick={() => setIsAddSlideModalActive(true)}>
                افزودن
              </button>
            </div>
          )}
        </div>
      </div>
      {isAddSlideModalActive && <AddSlideModal onClose={() => setIsAddSlideModalActive(false)} onSubmit={handleAddSlide} />}
    </>
  );
}
