import React, { useContext } from "react";
import Select from "react-select";

import * as _Upload from "$utilities/upload";
import ProductContext from "$contexts/pages/Shop/ProductEdit";

const statusOptions = [
  { value: "draft", label: "پیش نویس" },
  { value: "published", label: "منتشر شده" },
];

export default function Status() {
  const { productState, updateProductState } = useContext(ProductContext);

  return (
    <div className="card card-flush card-widget">
      {/*begin::Card header*/}
      <div className="card-header">
        {/*begin::Card title*/}
        <div className="card-title">
          <h2>وضعیت</h2>
        </div>
        {/*end::Card title*/}
      </div>
      {/*end::Card header*/}
      {/*begin::Card body*/}
      <div className="card-body">
        <Select options={statusOptions} isRtl={true} value={statusOptions.find((option) => option.value === productState.status)} onChange={(option) => updateProductState((state) => (state.status = option.value))} />
      </div>
      {/*end::Card body*/}
    </div>
  );
}
