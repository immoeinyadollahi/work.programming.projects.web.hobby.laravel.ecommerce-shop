import React from "react";

export default function BaseSidebar({ widgets }) {
  return (
    <div className="shop-layout__sidebar">
      <div className="block block-sidebar">
        <div className="block-sidebar__item">
          <div className="widget-filters widget">
            <h4 className="widget__title">فیلتر ها</h4>
            <div className="widget-filters__list">{widgets}</div>
          </div>
        </div>
      </div>
    </div>
  );
}
