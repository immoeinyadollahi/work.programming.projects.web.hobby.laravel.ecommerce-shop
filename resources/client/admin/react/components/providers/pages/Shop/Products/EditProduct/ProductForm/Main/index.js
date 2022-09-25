import React, { useContext } from "react";
import { Tabs, Tab } from "react-bootstrap";
import _ from "lodash";

import * as productsHttp from "$http/shop/products";
import ProductContext from "$contexts/pages/Shop/ProductEdit";
import useCheckUnsavedChanges from "$hooks/partials/useCheckUnsavedChanges";
import useData from "$hooks/actions/useData";
import { useState } from "$hooks/core/state";
import useErrorHandler from "$hooks/common/useErrorHandler";
import GeneralTab from "./GeneralTab";
import AdvancedTab from "./AdvancedTab";

export default function Main() {
  const [activeTabKey, setActiveTabKey] = useState("GeneralTab");
  const [isSubmiting, setIsSubmiting] = useState(false);
  const hasAnyUnsavedChanges = useCheckUnsavedChanges();
  const { data } = useData();
  const { handleHttpError } = useErrorHandler();
  const { productState, setErrors } = useContext(ProductContext);

  const handleSaveChanges = async () => {
    try {
      setIsSubmiting(true);
      await productsHttp.patchProduct(data.product.id, Object.assign(_.omit(productState, ["thumbnails", "image", "brandId"]), { thumbnails: productState.thumbnails.map((thumb) => thumb.id), image: productState.image?.id, brand_id: productState.brandId }));
      setIsSubmiting(false);
    } catch (err) {
      handleHttpError(err, {
        onBeforeDefaultAction: () => setIsSubmiting(false),
        onSetErrors: ({ errors }) => setErrors(Object.values(errors)),
      });
    }
  };
  return (
    <div className="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
      {/*begin:::Tabs*/}
      <Tabs
        activeKey={activeTabKey}
        onSelect={(key) => {
          if (!hasAnyUnsavedChanges(activeTabKey) || confirm("تغییراتی ذخیره نشده اند، آیا مایل اید ادامه دهید؟")) {
            setActiveTabKey(key);
          }
        }}
        mountOnEnter={true}
        unmountOnExit={true}
        className="nav-custom nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2"
      >
        {/*begin:::Tab item*/}
        <Tab eventKey="GeneralTab" title="عمومی" tabClassName="text-active-primary pb-4">
          <GeneralTab />
        </Tab>
        {/*end:::Tab item*/}
        {/*begin:::Tab item*/}
        <Tab eventKey="AdvancedTab" title="پیشرفته" tabClassName="text-active-primary pb-4">
          <AdvancedTab />
        </Tab>
        {/*end:::Tab item*/}
      </Tabs>
      {/*end:::Tabs*/}
      <div className="d-flex justify-content-end">
        {/*begin::Button*/}
        <button className="btn btn-secondary me-5" disabled={isSubmiting} onClick={() => (location.href = "/shop/products")}>
          انصراف
        </button>
        {/*end::Button*/}
        {/*begin::Button*/}
        <button className="btn btn-primary" disabled={isSubmiting} onClick={handleSaveChanges}>
          {isSubmiting ? <span className="spinner-border spinner-border-sm"></span> : "ذخیره تغییرات"}
        </button>
        {/*end::Button*/}
      </div>
    </div>
  );
}
