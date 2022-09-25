import React, { useContext } from "react";
import Select from "react-select";

import useData from "$hooks/actions/useData";
import ProductContext from "$contexts/pages/Shop/ProductEdit";

export default function Brand() {
  const { data } = useData();
  const { productState, updateProductState } = useContext(ProductContext);

  const handleSelectBrand = (brandId) => {
    updateProductState((state) => (state.brand = categoryBrands.find((brand) => brand.id === brandId)));
  };

  const category = data.product.main_category;
  const categoryBrands = category && category.brands;
  const selectedBrand = productState.brand;
  return (
    <>
      <div className="card card-flush card-widget">
        {/*begin::Card header*/}
        <div className="card-header">
          {/*begin::Card title*/}
          <div className="card-title">
            <h2>برند</h2>
          </div>
        </div>
        {/*end::Card header*/}
        {/*begin::Card body*/}
        <div className="card-body">
          {category ? (
            categoryBrands.length ? (
              <>
                <Select placeholder="برندی انتخاب کنید" className="mb-3" options={categoryBrands.map((brand) => ({ value: brand.id, label: brand.fa }))} isRtl={true} isSearchable={true} value={selectedBrand && _.pickAs(selectedBrand, { value: "id", label: "fa" })} onChange={(option) => handleSelectBrand(option.value)} />
              </>
            ) : (
              <div className="alert alert-primary text-center mb-0">در حال حاظر برندی برای دسته بندی وجود ندارد</div>
            )
          ) : (
            <div className="alert alert-primary text-center mb-0">دسته بندی انتخاب نشده است</div>
          )}
        </div>
        {/*end::Card body*/}
      </div>
    </>
  );
}
