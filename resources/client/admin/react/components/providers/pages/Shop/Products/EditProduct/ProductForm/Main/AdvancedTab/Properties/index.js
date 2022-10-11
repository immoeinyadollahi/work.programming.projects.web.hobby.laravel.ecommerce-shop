import React from "react";

import * as propertiesHttp from "$http/shop/products/properties";
import useData from "$hooks/actions/useData";
import { useState } from "$hooks/core/state";
import useErrorHandler from "$hooks/common/useErrorHandler";
import SelectPropertiesModal from "./SelectPropertiesModal";

export default function Properties() {
  const { data, setDataCallback } = useData();
  const [isFetching, setIsFetching] = useState(false);
  const [isSelectPropertiesModalActive, setIsSelectPropertiesModalActive] = useState(false);
  const { handleHttpError } = useErrorHandler();
  const fetchProperties = async () => {
    try {
      setIsFetching(true);
      const {
        data: { properties },
      } = await propertiesHttp.getProperties(data.product.id);
      setDataCallback((data) => (data.product.properties = properties));
      setIsFetching(false);
    } catch (err) {
      handleHttpError(err);
    }
  };
  const productProperties = data.product.properties;
  const category = data.product.main_category;
  return (
    <>
      <div className="card card-flush card-widget">
        {/*begin::Card header*/}
        <div className="card-header">
          <div className="card-title">
            <h2>ویژگی ها</h2>
          </div>
          {category && (
            <button className="btn btn-primary" onClick={() => setIsSelectPropertiesModalActive(true)}>
              ویرایش
            </button>
          )}
        </div>
        {/*end::Card header*/}
        {/*begin::Card body*/}
        <div className="card-body">
          {category ? (
            isFetching ? (
              <div className="d-flex justify-content-center mb-5">
                <span className="spinner-border"></span>
              </div>
            ) : category.properties.length ? (
              productProperties.length ? (
                <div className="table-responsive product-properties-table">
                  <table className="table table-striped gy-5 gx-3">
                    <thead>
                      <tr className="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th>نام</th>
                        <th>مقدار</th>
                      </tr>
                    </thead>
                    <tbody>
                      {productProperties.map((property) => (
                        <tr key={property.id}>
                          <td>{property.name}</td>
                          <td>{property.pivot.value.value}</td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
              ) : (
                <div className="alert alert-primary mb-0">در حال حاظر ویژگی برای محصول انتخاب نشده است</div>
              )
            ) : (
              <div className="alert alert-primary mb-0">در حال حاظر ویژگی برای دسته بندی انتخاب نشده است</div>
            )
          ) : (
            <div className="alert alert-primary mb-0">دسته بندی انتخاب نشده است</div>
          )}
        </div>
        {/*end::Card body*/}
      </div>
      {isSelectPropertiesModalActive && <SelectPropertiesModal onClose={() => setIsSelectPropertiesModalActive(false)} onSave={fetchProperties} />}
    </>
  );
}
