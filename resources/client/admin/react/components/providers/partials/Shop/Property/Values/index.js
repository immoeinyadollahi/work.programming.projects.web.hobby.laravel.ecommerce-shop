import React from "react";
import _ from "lodash";

import { useState } from "$hooks/core/state";

const initialValues = _getData("pageData.propertyValues", []).map((value) => ({
    value: value.value,
    key: _.uniqueId(),
}));

export default function Values() {
    const [values, setValues, updateValues] = useState(initialValues);
    return (
        <div>
            <div className="d-flex align-items-center">
                <h4 className="mb-0">مقادیر</h4>
                <button
                    className="btn btn-sm btn-primary ms-5"
                    type="button"
                    onClick={() =>
                        setValues(
                            values.concat({ value: "", key: _.uniqueId() })
                        )
                    }
                >
                    افزودن
                </button>
            </div>
            {values.length ? (
                <div>
                    {values.map((value, idx) => (
                        <div className="row mt-3" key={value.key}>
                            <div className="col-xl-4 col-sm-6">
                                <div className="d-flex align-items-center">
                                    <span className="badge badge-circle badge-secondary flex-shrink-0">
                                        {idx + 1}
                                    </span>
                                    <input
                                        type="text"
                                        className="form-control mx-3"
                                        name={`values[${idx}]`}
                                        value={value.value}
                                        onChange={(e) =>
                                            updateValues(
                                                (state) =>
                                                    (state[idx].value =
                                                        e.target.value)
                                            )
                                        }
                                    />
                                    <button
                                        className="btn btn-danger flex-shrink-0"
                                        onClick={() =>
                                            updateValues((state) =>
                                                state.splice(idx, 1)
                                            )
                                        }
                                    >
                                        <span className="fal fa-trash"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            ) : null}
        </div>
    );
}
