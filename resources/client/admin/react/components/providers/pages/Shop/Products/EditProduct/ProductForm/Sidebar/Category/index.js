import React from "react";
import _ from "lodash";

import useData from "$hooks/actions/useData";
import { useState } from "$hooks/core/state";
import SelectCategoryModal from "./SelectCategoryModal";

export default function Category() {
  const [isSelectCategoryModalActive, setIsSelectCategoryModalActive] = useState(false);
  const { data, setDataCallback } = useData();

  const handleUpdateCategories = (categories, mainCategory) => {
    setDataCallback((data) => {
      Object.assign(data.product, { categories, main_category: mainCategory, properties: [], variable_type: { attributes: [], variations: [] } });
      data.productMainCategoryChange = {};
    });
  };

  const mainCategory = data.product.main_category;
  return (
    <>
      <div className="card card-flush card-widget">
        {/*begin::Card header*/}
        <div className="card-header">
          {/*begin::Card title*/}
          <div className="card-title">
            <h2>دسته بندی</h2>
          </div>
          {/*end::Card title*/}
          <button className="btn btn-sm btn-primary" onClick={() => setIsSelectCategoryModalActive(true)}>
            {mainCategory ? "ویرایش" : "افزودن"}
          </button>
        </div>
        {/*end::Card header*/}
        {/*begin::Card body*/}
        <div className="card-body">{mainCategory ? <h4 className="text-center m-0"> {mainCategory.fa} </h4> : <div className="alert alert-primary text-center mb-0">دسته بندی انتخاب نشده است</div>}</div>
        {/*end::Card body*/}
      </div>
      {isSelectCategoryModalActive && <SelectCategoryModal onClose={() => setIsSelectCategoryModalActive(false)} onSave={handleUpdateCategories} />}
    </>
  );
}
