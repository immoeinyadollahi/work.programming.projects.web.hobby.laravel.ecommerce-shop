import React from "react";

import Image from "./Image";
import Status from "./Status";
import Brand from "./Brand";
import Category from "./Category";

export default function Sidebar() {
  return (
    <div className="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
      <Image />
      <Status />
      <Brand />
      <Category />
    </div>
  );
}
