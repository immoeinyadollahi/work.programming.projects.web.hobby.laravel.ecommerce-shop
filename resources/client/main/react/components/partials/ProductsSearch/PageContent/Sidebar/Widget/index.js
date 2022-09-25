import React from "react";

import { useState } from "$hooks/core/state";

export default function Widget({ title, children, defaultOpen = false }) {
  const [isContentOpened, setIsContentOpened] = useState(defaultOpen || !title);
  return (
    <div className="widget-filters__item">
      <div className={`filter${isContentOpened ? " filter--opened" : ""}`}>
        {title && (
          <button type="button" className="filter__title" onClick={() => setIsContentOpened(!isContentOpened)}>
            {title}
            <svg className="filter__arrow" width="12px" height="7px">
              <use xlinkHref="/public/main/images/sprite.svg#arrow-rounded-down-12x7"></use>
            </svg>
          </button>
        )}
        {isContentOpened && (
          <div className="filter__body">
            <div className="filter__container">{children}</div>
          </div>
        )}
      </div>
    </div>
  );
}
