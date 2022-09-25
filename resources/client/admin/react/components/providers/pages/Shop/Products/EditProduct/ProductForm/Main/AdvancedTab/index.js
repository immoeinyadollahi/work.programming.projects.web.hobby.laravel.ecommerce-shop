import React from "react";

import Info from "./Info";
import Properties from "./Properties";
import Specs from "./Specs";

export default function AdvancedTab() {
  return (
    <div className="d-flex flex-column gap-7 gap-lg-10">
      {/*begin::Product Info*/}
      <Info />
      {/*end::Product Info*/}
      {/* temp */}
      {/*begin::Properties*/}
      <Properties />
      {/*end::Properties*/}
      {/*begin::Specs*/}
      <Specs />
      {/*end::Specs*/}
    </div>
  );
}
