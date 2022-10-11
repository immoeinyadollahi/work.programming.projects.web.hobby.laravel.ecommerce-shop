import React, { useMemo } from "react";
import { useFormik } from "formik";
import _ from "lodash";

import DatePicker from "$components/common/DatePicker";

export default function Content({ variation, errors, updateVariation }) {
  const initialValues = useMemo(() => _.omit(variation, ["id", "attributes"]), []);
  const formik = useFormik({
    initialValues,
  });
  const updateVariationField = (key, value) => updateVariation((variation) => (variation[key] = value));
  return (
    <div className="mt-10">
      {/*begin::Input group*/}
      <div className="mb-5">
        {/*begin::Tags*/}
        <label className="form-label">قیمت اصلی (تومان)</label>
        {/*end::Tags*/}
        {/*begin::Input*/}
        <input
          type="text"
          name="price"
          className={`form-control mb-2${errors.price ? " is-invalid" : ""}`}
          placeholder="قیمت اصلی را وارد کنید"
          value={formik.values.price}
          onChange={formik.handleChange}
          onBlur={(e) => e.target.value != variation.price && updateVariationField("price", formik.values.price)}
        />
        {errors.price && <div className="invalid-feedback">{errors.price}</div>}
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
            onChange={(e) => {
              formik.setFieldValue("has_discount", e.target.checked);
              updateVariationField("has_discount", e.target.checked);
            }}
          />
          <label className="form-check-label" htmlFor="simple-su-has-discount-input">
            تخفیف
          </label>
        </div>
        {/*end::Input*/}
      </div>
      {/*end::Input group*/}
      {variation.has_discount && (
        <div className="row">
          <div className="col-md-6 mb-5">
            {/*begin::Tags*/}
            <label className="form-label">قیمت تخفیف (تومان)</label>
            {/*end::Tags*/}
            {/*begin::Input*/}
            <input
              type="text"
              name="discounted_price"
              className={`form-control mb-2${errors.discounted_price ? " is-invalid" : ""}`}
              placeholder="قیمت تخفیف را وارد کنید"
              value={formik.values.discounted_price}
              onChange={formik.handleChange}
              onBlur={(e) => e.target.value != variation.discounted_price && updateVariationField("discounted_price", formik.values.discounted_price)}
            />
            {errors.discounted_price && <div className="invalid-feedback">{errors.discounted_price}</div>}
            {/*end::Input*/}
          </div>
          <div className="col-md-6 mb-5">
            {/*begin::Tags*/}
            <label className="form-label">انقضا تخفیف</label>
            {/*end::Tags*/}
            {/*begin::Input*/}
            <DatePicker initialValue={variation.discount_expire} onChange={(date) => updateVariationField("discount_expire", new Date(date))} />
            {errors.discount_expire && <div className="invalid-feedback">{errors.discount_expire}</div>}
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
          className={`form-control mb-2${errors.stock ? " is-invalid" : ""}`}
          placeholder="موجودی انبار را وارد کنید"
          value={formik.values.stock}
          onChange={formik.handleChange}
          onBlur={(e) => e.target.value != variation.stock && updateVariationField("stock", formik.values.stock)}
        />
        {/*end::Input*/}
        {errors.stock && <div className="invalid-feedback">{errors.stock}</div>}
      </div>
      {/*end::Input group*/}
      {/*begin::Input group*/}
      <div>
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
          onBlur={(e) => e.target.value !== variation.description && updateVariationField("description", formik.values.description)}
        ></textarea>
        {/*end::Input*/}
      </div>
      {/*end::Input group*/}
    </div>
  );
}
