import React, { useContext } from "react";
import { CKEditor } from "ckeditor4-react";

import ProductContext from "$contexts/pages/Shop/ProductEdit";
import Gallery from "./Gallery";

export default function GeneralTab() {
  const { productState, setProductStateKeyValue } = useContext(ProductContext);
  return (
    <div className="d-flex flex-column gap-7 gap-lg-10">
      {/*begin::عمومی options*/}
      <div className="card card-flush card-widget">
        {/*begin::Card header*/}
        <div className="card-header">
          <div className="card-title">
            <h2>عمومی</h2>
          </div>
        </div>
        {/*end::Card header*/}
        {/*begin::Card body*/}
        <div className="card-body">
          {/*begin::Input group*/}
          <div className="mb-10 fv-row">
            {/*begin::Tags*/}
            <label className="required form-label">نام</label>
            {/*end::Tags*/}
            {/*begin::Input*/}
            <input type="text" name="product_name" className="form-control mb-2" placeholder="نام محصول" value={productState.name} onChange={(e) => setProductStateKeyValue("name", e.target.value)} />
            {/*end::Input*/}
            {/*begin::توضیحات*/}
            <div className="text-muted fs-7">نام محصول مورد نیاز است و توصیه می شود منحصر به فرد باشد.</div>
            {/*end::توضیحات*/}
          </div>
          {/*end::Input group*/}
          {/*begin::Input group*/}
          <div>
            {/*begin::Tags*/}
            <label className="form-label">توضیحات</label>
            {/*end::Tags*/}
            {/*begin::Input*/}
            <CKEditor
              onChange={(e) => setProductStateKeyValue("description", e.editor.getData())}
              initData={
                <p
                  dangerouslySetInnerHTML={{
                    __html: productState.description,
                  }}
                ></p>
              }
              config={{
                editorPlaceholder: "توضیحات محصول",
                language: "fa",
              }}
            />
            {/*end::Input*/}
          </div>
          {/*end::Input group*/}
        </div>
        {/*end::Card header*/}
      </div>
      {/*end::عمومی options*/}
      <Gallery />
    </div>
  );
}
