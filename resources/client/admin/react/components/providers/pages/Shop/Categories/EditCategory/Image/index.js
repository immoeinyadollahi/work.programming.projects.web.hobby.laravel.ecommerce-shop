import React, { useContext } from "react";
import path from "path-browserify";
import { ProgressBar } from "react-bootstrap";

import * as mediaHttp from "$http/shop/categories/media";
import * as _Upload from "$utilities/upload";
import useErrorHandler from "$hooks/common/useErrorHandler";
import { useState } from "$hooks/core/state";

export default function Image() {
  const [error, setError] = useState();
  const [image, setImage] = useState();
  const [uploadFile, setUploadFile] = useState();
  const [isUploading, setIsUploading] = useState();
  const [uploadProgress, setUploadProgress] = useState(0);
  const { handleHttpError } = useErrorHandler();

  const handleImageInputChange = (e) => {
    setError();
    const file = e.target.files[0];
    if (file.size > 5000000) {
      setError("تصویر باید کمتر از 5 مگابایت باشد");
    } else if (![".png", ".jpg", ".jpeg"].includes(path.extname(file.name))) {
      setError("فرمت فایل باید PNG ، JPG یا JPEG باشد");
    } else {
      setUploadFile(file);
      // preview
      const reader = new FileReader();
      reader.addEventListener("load", (e) => setImage(image ? { ...image, url: e.target.result } : { url: e.target.result }));
      reader.readAsDataURL(file);
    }
    e.target.value = "";
  };
  const resetUpload = () => {
    setUploadFile();
    setIsUploading(false);
    setUploadProgress(0);
  };
  const handleStartUpload = async () => {
    try {
      setIsUploading(true);
      const formData = new FormData();
      formData.append("image", uploadFile);
      const {
        data: { image_id, image_url },
      } = await mediaHttp.postImage(formData, {
        onUploadProgress: (e) => setUploadProgress(_Upload.calculateProgress(e.loaded, e.total)),
      });
      setImage({ id: image_id, url: image_url });
      resetUpload();
    } catch (err) {
      handleHttpError(err, {
        onBeforeDefaultAction: () => (resetUpload(), setError("مشکلی در انجام عملیات پیش آمده است")),
      });
    }
  };
  return (
    <div className="card card-flush card-widget">
      <input type="hidden" value={image ? image.id : ""} name="image" />
      {/*begin::Card header*/}
      <div className="card-header">
        {/*begin::Card title*/}
        <div className="card-title">
          <h2>تصویر شاخص</h2>
        </div>
        {/*end::Card title*/}
      </div>
      {/*end::Card header*/}
      {/*begin::Card body*/}
      <div className="card-body text-center">
        {/*begin::Image input*/}
        <div className="image-input image-input-outline" data-kt-image-input="true">
          {/*begin::نمایش existing avatar*/}
          <div
            className="image-input-wrapper w-150px h-150px"
            style={
              image
                ? {
                    backgroundImage: `url(${image.url})`,
                    backgroundPosition: "center",
                  }
                : {}
            }
          />
          {/*end::نمایش existing avatar*/}
          {/*begin::Tags*/}
          <label className="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change">
            <i className="bi bi-pencil-fill fs-7" />
            {/*begin::Inputs*/}
            <input type="file" accept=".png,.jpg,.jpeg" onChange={handleImageInputChange} />
            {/*end::Inputs*/}
          </label>
          {/*end::Tags*/}
          {/*begin::انصراف*/}
          {image && (
            <span className="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" onClick={(() => setImage(), uploadFile && setUploadFile())}>
              <i className="bi bi-x fs-2" />
            </span>
          )}
          {/*end::انصراف*/}
        </div>
        {/*end::Image input*/}
        {error && <div className="text-danger fs-7 mt-4">{error}</div>}
        {uploadFile && (
          <div className="d-flex justify-content-center mt-4">
            {isUploading ? (
              <ProgressBar className="w-100" now={uploadProgress} label={`${uploadProgress}%`} />
            ) : (
              <button className="btn btn-success" onClick={handleStartUpload}>
                آپلود
              </button>
            )}
          </div>
        )}
      </div>
      {/*end::Card body*/}
    </div>
  );
}
