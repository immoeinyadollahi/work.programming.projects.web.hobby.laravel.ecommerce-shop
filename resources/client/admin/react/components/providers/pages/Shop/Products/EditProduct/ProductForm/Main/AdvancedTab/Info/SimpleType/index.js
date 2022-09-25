import React, { useMemo } from "react";
import { useFormik } from "formik";
import _ from "lodash";

import * as simpleTypeHttp from "$http/shop/products/simple-type";
import useData from "$hooks/actions/useData";
import { useState } from "$hooks/core/state";
import useErrorHandler from "$hooks/common/useErrorHandler";
import DatePicker from "$components/common/DatePicker";

export default function SimpleType() {
    const { data, setDataCallback } = useData();
    const su = data.product.simple_type.su;
    const [isSubmiting, setIsSubmiting] = useState(false);
    const { handleHttpError, clearErrors, errors } = useErrorHandler();
    const initialValues = useMemo(
        () => ({
            price: su.price || "",
            discounted_price: su.discounted_price || "",
            discount_expire: su.discount_expire || "",
            stock: su.stock || "",
            description: su.description || "",
            has_discount: Boolean(su.discounted_price),
        }),
        []
    );
    const formik = useFormik({
        initialValues,
        async onSubmit(values) {
            clearErrors();
            setIsSubmiting(true);
            try {
                const {
                    data: { su },
                } = await simpleTypeHttp.patchSu(
                    data.product.id,
                    Object.assign(
                        ..._.omit(values, "has_discount"),
                        values.has_discount
                            ? {}
                            : {
                                  discounted_price: null,
                                  discount_expire: null,
                              }
                    )
                );
                setDataCallback((data) => (data.product.simple_type.su = su));
                setIsSubmiting(false);
            } catch (err) {
                handleHttpError(err, {
                    onBeforeDefaultAction: () => setIsSubmiting(false),
                });
            }
        },
    });
    return (
        <form onSubmit={formik.handleSubmit}>
            {/*begin::Input group*/}
            <div className="mb-5">
                {/*begin::Tags*/}
                <label className="form-label">قیمت اصلی (تومان)</label>
                {/*end::Tags*/}
                {/*begin::Input*/}
                <input
                    type="text"
                    name="price"
                    className={`form-control mb-2${
                        errors.price ? " is-invalid" : ""
                    }`}
                    placeholder="قیمت اصلی را وارد کنید"
                    value={formik.values.price}
                    onChange={formik.handleChange}
                />
                {errors.price && (
                    <div className="invalid-feedback">{errors.price}</div>
                )}
                {/*end::Input*/}
            </div>
            {/*end::Input group*/}
            {/*begin::Input group*/}
            <div className="mb-5">
                {/*begin::Tags*/}
                <div className="form-check form-check-custom form-check-sm">
                    <input
                        id="simple-su-has-discount-input"
                        className="form-check-input"
                        name="has_discount"
                        type="checkbox"
                        checked={formik.values.has_discount}
                        onChange={formik.handleChange}
                    />
                    <label
                        className="form-check-label"
                        htmlFor="simple-su-has-discount-input"
                    >
                        تخفیف
                    </label>
                </div>
                {/*end::Input*/}
            </div>
            {/*end::Input group*/}
            {formik.values.has_discount && (
                <div className="row">
                    <div className="col-md-6 mb-5">
                        {/*begin::Tags*/}
                        <label className="form-label">قیمت تخفیف (تومان)</label>
                        {/*end::Tags*/}
                        {/*begin::Input*/}
                        <input
                            type="text"
                            name="discounted_price"
                            className={`form-control mb-2${
                                errors.discounted_price ? " is-invalid" : ""
                            }`}
                            placeholder="قیمت تخفیف را وارد کنید"
                            value={formik.values.discounted_price}
                            onChange={formik.handleChange}
                        />
                        {errors.discounted_price && (
                            <div className="invalid-feedback">
                                {errors.discounted_price}
                            </div>
                        )}
                        {/*end::Input*/}
                    </div>
                    <div className="col-md-6 mb-5">
                        {/*begin::Tags*/}
                        <label className="form-label">انقضا تخفیف</label>
                        {/*end::Tags*/}
                        {/*begin::Input*/}
                        <DatePicker
                            initialValue={formik.values.discount_expire}
                            onChange={(date) =>
                                formik.setFieldValue("discount_expire", date)
                            }
                        />
                        {errors.price && (
                            <div className="invalid-feedback">
                                {errors.price}
                            </div>
                        )}
                        {/*end::Input*/}
                    </div>
                </div>
            )}
            {/*begin::Input group*/}
            <div className="mb-5">
                {/*begin::Tags*/}
                <label className="form-label">موجودی انبار</label>
                {/*end::Tags*/}
                {/*begin::Input*/}
                <input
                    type="number"
                    name="stock"
                    className={`form-control mb-2${
                        errors.price ? " is-invalid" : ""
                    }`}
                    placeholder="موجودی انبار را وارد کنید"
                    value={formik.values.stock}
                    onChange={formik.handleChange}
                />
                {/*end::Input*/}
                {errors.stock && (
                    <div className="invalid-feedback">{errors.stock}</div>
                )}
            </div>
            {/*end::Input group*/}
            {/*begin::Input group*/}
            <div className="mb-5">
                {/*begin::Tags*/}
                <label className="form-label">توضیحات</label>
                {/*end::Tags*/}
                {/*begin::Input*/}
                <textarea
                    className="resize-none form-control"
                    name="description"
                    cols="30"
                    rows="5"
                    placeholder="متن توضیحات را وارد کنید"
                    value={formik.values.description}
                    onChange={formik.handleChange}
                ></textarea>
                {/*end::Input*/}
            </div>
            {/*end::Input group*/}
            <div className="d-flex justify-content-end">
                <button className="btn btn-primary" disabled={isSubmiting}>
                    {isSubmiting ? (
                        <span className="spinner-border spinner-border-sm"></span>
                    ) : (
                        "ذخیره تغییرات"
                    )}
                </button>
            </div>
        </form>
    );
}
