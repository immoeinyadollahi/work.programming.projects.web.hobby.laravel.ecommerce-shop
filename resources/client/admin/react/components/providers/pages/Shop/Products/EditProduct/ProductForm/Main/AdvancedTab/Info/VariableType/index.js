import React from "react";
import { Tabs, Tab } from "react-bootstrap";

import useCheckUnsavedChanges from "$hooks/partials/useCheckUnsavedChanges";
import { useState } from "$hooks/core/state";
import useData from "$hooks/actions/useData";
import AttributesTab from "./AttributesTab";
import VariationsTab from "./VariationsTab";

export default function VariableType() {
  const { data } = useData();
  const hasAnyUnsavedChanges = useCheckUnsavedChanges();
  const [activeTabKey, setActiveTabKey] = useState("AttributesTab");

  const category = data.product.main_category;
  return category ? (
    category.attributes.length ? (
      <Tabs
        activeKey={activeTabKey}
        onSelect={(key) => {
          if (!hasAnyUnsavedChanges(`AdvancedTab.VariableType.${activeTabKey}`) || confirm("تغییراتی ذخیره نشده اند، آیا مایل اید ادامه دهید؟")) {
            setActiveTabKey(key);
          }
        }}
        mountOnEnter={true}
        unmountOnExit={true}
        className="nav-custom nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-10 nav-justified"
      >
        {/*begin:::Tab item*/}
        <Tab eventKey="AttributesTab" title="خصوصیت ها" tabClassName="text-active-primary pb-4">
          <AttributesTab setActiveTab={setActiveTabKey} />
        </Tab>
        {/*end:::Tab item*/}
        {/*begin:::Tab item*/}
        <Tab eventKey="VariationsTab" title="متغیر ها" tabClassName="text-active-primary pb-4">
          <VariationsTab setActiveTab={setActiveTabKey} />
        </Tab>
        {/*end:::Tab item*/}
      </Tabs>
    ) : (
      <div className="alert alert-primary mb-0">در حال حاظر خصوصیتی برای دسته بندی وجود ندارد</div>
    )
  ) : (
    <div className="alert alert-primary mb-0">دسته بندی انتخاب نشده است</div>
  );
}
