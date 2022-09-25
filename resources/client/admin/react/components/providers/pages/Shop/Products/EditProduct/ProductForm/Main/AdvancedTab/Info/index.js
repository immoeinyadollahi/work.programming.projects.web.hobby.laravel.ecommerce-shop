import React from "react";

import useData from "$hooks/actions/useData";
import SimpleType from "./SimpleType";
import VariableType from "./VariableType";

const productTypes = {
    simple: <SimpleType />,
    variable: <VariableType />,
};

export default function Info() {
    const { data, setDataCallback } = useData();
    return (
        <div className="card card-flush card-widget">
            {/*begin::Card header*/}
            <div className="card-header">
                <div className="d-flex align-items-center">
                    <div className="card-title">
                        <h2>اطلاعات محصول</h2>
                    </div>
                    <select
                        className="form-select ms-4"
                        value={data.product.type}
                        onChange={(e) =>
                            setDataCallback(
                                (data) => (data.product.type = e.target.value)
                            )
                        }
                    >
                        <option value="simple">محصول ساده</option>
                        <option value="variable">محصول متغیر</option>
                    </select>
                </div>
            </div>
            {/*end::Card header*/}
            {/*begin::Card body*/}
            <div className="card-body">{productTypes[data.product.type]}</div>
            {/*end::Card header*/}
        </div>
    );
}
